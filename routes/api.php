<?php

use App\Models\Product;
use App\Models\Recall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});

Route::post('search', function (Request $request) {
    $where = fn ($query) => $query->whereIn('id', $request->get('products'));
    return Recall::with(['products' => $where])->whereHas('products', $where)->get();
});
Route::get('recalls', function (Request $request) {
    return Recall::withCount('products', 'dispensaries')->get();
});