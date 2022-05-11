<?php

use App\Models\Dispensary;
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
        $query->where('name', 'like', '%'.request()->get('q').'%')
        ->orWhere('license_number', 'like', '%'.request()->get('q').'%');
    }
    if (request()->has('type')) {
        $query->where('license_type', request()->get('type'));
    }

    return view('dispensaries', [
        'dispensaries' => $query->paginate(15, ['*'], 'page', request('page', 1)),
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
