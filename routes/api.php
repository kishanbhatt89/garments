<?php

use App\Http\Controllers\Api\v1\AuthController as AuthController;
use App\Http\Controllers\Api\v1\StoreController;
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

Route::prefix('v1')->controller(AuthController::class)->group(function () {

    Route::post('login', 'login');

    //Route::post('register', 'register');

    Route::middleware('auth:api')->group(function () {

        Route::post('logout', 'logout');
        Route::post('me', 'me');

    });

});

Route::prefix('v1')->controller(StoreController::class)->group(function () {

    Route::middleware('auth:api')->group(function () {

        Route::get('store/show/{store}', 'show');
        Route::post('store/save', 'store');
        Route::patch('store/{store}/update', 'update');
        Route::delete('store/{store}/delete', 'destroy');

    });

});