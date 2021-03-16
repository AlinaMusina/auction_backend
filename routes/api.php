<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ItemsController;
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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('items')->group(function(){
    Route::get('/', [ItemsController::class, 'getAll']);
    Route::get('/{id}', [ItemsController::class, 'getById']);
    Route::post('/{id}/bid', [ItemsController::class, 'createBid']);
    Route::post('/{id}/auto_bid', [ItemsController::class, 'createAutoBid']);
    Route::delete('/{id}/auto_bid', [ItemsController::class, 'removeAutoBid']);
});
Route::prefix('config')->group(function(){
    Route::get('/', [ConfigController::class, 'getConfig']);
    Route::post('/', [ConfigController::class, 'updateConfig']);
});

