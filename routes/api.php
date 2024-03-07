<?php

use App\Models\Dispensary;
use App\Models\Product;
use App\Models\Recall;
use App\Models\Strain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use Symfony\Contracts\Service\Attribute\Required;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user->load('likes.likeable', 'followings.followable', 'favorites.favoriteable');
    return $user;
});

Route::post('search', function (Request $request) {
    $where = fn ($query) => $query->whereIn('products.product_id', $request->get('products'));
    return Recall::with(['products' => $where])->whereHas('products', $where)->get();
});
Route::get('recalls', function (Request $request) {
    return Recall::query()
        ->withCount('products', 'dispensaries')
        ->orderByDesc('published_at')
        ->get();
});
Route::get('licensed-locations', function (Request $request) {
    return \Spatie\QueryBuilder\QueryBuilder::for(Dispensary::class)
        ->allowedFilters([
            'name', 'address', 'url', 'email'
        ])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();
});

Route::middleware('auth:sanctum')->post('/like', function (Request $request) {
    $request->validate([
        'likeable_id' => 'required|integer',
        'likeable_type' => [
            'required',
            'in:App\Models\Product,App\Models\Dispensary,App\Models\Strain'
        ],
    ]);
    $type = $request->get('likeable_type');
    $like = $type::find($request->get('likeable_id'));
    if ($request->user()->hasLiked($like)) {
        $request->user()->unlike($like);
        return ;
    }

    $like = $request->user()->like($like);

    return $like;
});

Route::middleware('auth:sanctum')->post('/follow', function (Request $request) {
    $request->validate([
        'followable_id' => 'required|integer',
        'followable_type' => [
            'required',
            'in:App\Models\Product,App\Models\Dispensary,App\Models\Strain,App\Models\Recall'
        ],
    ]);
    $type = $request->get('followable_type');
    $follow = $type::find($request->get('followable_id'));

    if ($request->user()->isFollowing($follow)) {
        $request->user()->unfollow($follow);
        return ;
    }

    $follow = $request->user()->follow($follow);

    return $follow;
});

Route::middleware('auth:sanctum')->post('/favorite', function (Request $request) {
    $request->validate([
        'favoriteable_id' => 'required|integer',
        'favoriteable_type' => [
            'required',
            'in:App\Models\Product,App\Models\Dispensary,App\Models\Strain,App\Models\Recall'
        ],
    ]);
    $type = $request->get('favoriteable_type');
    $favorite = $type::find($request->get('favoriteable_id'));

    if ($request->user()->hasFavorited($favorite)) {
        $request->user()->unfavorite($favorite);
        return;
    }

    $favorite = $request->user()->favorite($favorite);

    return $favorite;
});

Route::middleware('auth:sanctum')->get('/feed', function (Request $request) {
    $user = $request->user();
    $user->load('likes.likeable', 'followings.followable', 'favorites.favoriteable');
    $follows = $user->followings->mapToGroups(function ($like) {
        return [$like->followable_type => $like->followable_id];
    });
    $likes = $user->likes->mapToGroups(function ($like) {
        return [$like->likeable_type => $like->likeable_id];
    });
    $favorites = $user->favorites->mapToGroups(function ($like) {
        return [$like->favoriteable_type => $like->favoriteable_id];
    });

    $types = $follows->keys()
    ->concat($likes->keys())
    ->concat($favorites->keys())
    ->unique();
    $notIn = collect([Product::class, Dispensary::class])->diff($types);
    $query = Activity::query();
    $query->where(function ($query) use ($follows) {
        foreach ($follows as $model => $ids) {
            $query->orWhere(function ($query) use ($model, $ids) {
                $query->where('subject_type', $model)
                    ->whereIn('subject_id', $ids);
            });
        }

        $query->orWhere(function ($query) {
            $query->where('causer_type', 'App\Models\User')
                ->where('causer_id', request()->user()->id);
        });
    });
    return $query->orderBy('updated_at', 'desc')
        ->with('subject', 'causer')
        ->paginate(request('limit', 100), ['*'], 'page', request('page'));
});
Route::middleware('auth:sanctum')->get('/facilities', function (Request $request) {
    $query = Dispensary::query();

    if ($request->has('query')) {
        $query->where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->get('query') . '%')
            ->orWhere('license_number', 'like', '%' . $request->get('query') . '%');
        });
    }

    if ($request->has('filter')) {
        array_map(function ($value, $key) use ($query) {
            $query->where(function ($query) use ($value, $key) {

                if (str_starts_with($value, 'in:')) {
                    $query->whereIn($key, explode(',', substr($value, 3)));
                } else {
                    $query->where($key, $value);
                }
            });
        }, $request->get('filter'), array_keys($request->get('filter')));
    }

    return $query->paginate(request('limit', 100), ['*'], 'page', request('page', 1));
});

Route::middleware('auth:sanctum')->get('/strains', function (Request $request) {
    $query = Strain::query();

    if ($request->has('query')) {
        $query->where(function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->get('query') . '%');
        });
    }

    if ($request->has('filter')) {
        array_map(function ($value, $key) use ($query) {
            $query->where(function ($query) use ($value, $key) {

                if (str_starts_with($value, 'in:')) {
                    $query->whereIn($key, explode(',', substr($value, 3)));
                } else {
                    $query->where($key, $value);
                }
            });
        }, $request->get('filter'), array_keys($request->get('filter')));
    }

    return $query->paginate(request('limit', 100), ['*'], 'page', request('page', 1));
});
