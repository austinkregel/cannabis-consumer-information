<?php

use App\Models\Dispensary;
use App\Models\Recall;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dispensaries', function () {
    $query = Dispensary::query();
    request()->validate([
        'type' => Rule::in([
            'prequalification',
            'grower',
            'provisioning',
            'individual',
            'compliance',
            'adult_use_entity',
            'processor',
            'event',
            'retailer',
            'transporter',
            'microbusiness',
            'temporary_event',
            'consumption',
            'complicance',
            'sole_proprietor',
        ]),
    ]);

    if (request()->has('q')) {
        $query->where(function ($query) {
            $query->where('name', 'like', '%'.request()->get('q').'%')
                ->orWhere('address', 'like', '%'.request()->get('q').'%')
                ->orWhere('license_number', 'like', '%'.request()->get('q').'%');
        });
    }
    $query->where('is_recreational', request('is_recreational', 'true') === "true");
    
    $query->whereIn('license_type', [
        'retailer',
        'provisioning',
    ]);

    return view('dispensaries', [
        'dispensaries' => $query->paginate(25, ['*'], 'page', request('page', 1)),
    ]);
});
Route::get('/testers', function () {
    $query = Dispensary::query();
    request()->validate([
        'type' => Rule::in([
            'prequalification',
            'grower',
            'provisioning',
            'individual',
            'compliance',
            'adult_use_entity',
            'processor',
            'event',
            'retailer',
            'transporter',
            'microbusiness',
            'temporary_event',
            'consumption',
            'complicance',
            'sole_proprietor',
        ]),
    ]);

    if (request()->has('q')) {
        $query->where(function ($query) {
            $query->where('name', 'like', '%'.request()->get('q').'%')
                ->orWhere('address', 'like', '%'.request()->get('q').'%')
                ->orWhere('license_number', 'like', '%'.request()->get('q').'%');
        });
    }

    $query->where('is_recreational', request('is_recreational', 'true') === "true");

    $query->whereIn('license_type', [
        'processor',
        'sole_proprietor',
        'compliance',
    ]);

    return view('dispensaries', [
        'dispensaries' => $query->paginate(25, ['*'], 'page', request('page', 1)),
    ]);
});
Route::get('/growers', function () {
    $query = Dispensary::query();
    request()->validate([
        'type' => Rule::in([
            'prequalification',
            'grower',
            'provisioning',
            'individual',
            'compliance',
            'adult_use_entity',
            'processor',
            'event',
            'retailer',
            'transporter',
            'microbusiness',
            'temporary_event',
            'consumption',
            'complicance',
            'sole_proprietor',
        ]),
    ]);

    if (request()->has('q')) {
        $query->where(function ($query) {
            $query->where('name', 'like', '%'.request()->get('q').'%')
                ->orWhere('address', 'like', '%'.request()->get('q').'%')
                ->orWhere('license_number', 'like', '%'.request()->get('q').'%');
        });
    }

    $query->where('is_recreational', request('is_recreational', 'true') === "true");

    $query->whereIn('license_type', ['grower']);

    return view('dispensaries', [
        'dispensaries' => $query->paginate(25, ['*'], 'page', request('page', 1)),
    ]);
});

Route::get('/dispensary/{dispensary:license_number}', function (Dispensary $dispensary) {
    $dispensary->load('recalls');

    return view('dispensary', compact('dispensary'));
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/recall/{recall:id}', function (App\Models\Recall $recall) {
    $recall->load('dispensaries', 'products');

    $recall = Recall::with([
        'dispensaries' => function ($query) {
            $query->withCount('recalls');
        }, 
    ])
    ->withCount('products')
    ->find($recall->id);

    return view('recall', compact('recall'));
});

require __DIR__.'/auth.php';
