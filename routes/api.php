<?php

use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Api\v1\AuthController as AuthController;
use App\Http\Controllers\Api\v1\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Api\v1\Client\CategoryController;
use App\Http\Controllers\Api\v1\Client\StateController as ClientStateController;
use App\Http\Controllers\Api\v1\Client\StoreController;
use App\Http\Controllers\Api\v1\Client\TypeController;
use App\Http\Controllers\Api\v1\Client\VerficationController as ClientVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Support\Facades\Artisan;

Route::get('v1/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return response()->json(['message' => 'Cache cleared']);

});

Route::group(['prefix' => 'v1/client','middleware' => ['assign.guard:client']],function ()
{
    Route::post('register', [ClientAuthController::class, 'register']);
    
    Route::get('email/verify/{id}', [ClientVerificationController::class, 'emailVerify'])->name('verification.verify');
    Route::get('email/resend', [ClientVerificationController::class, 'emailResend'])->name('verification.resend');

    Route::post('otp/verify', [ClientVerificationController::class, 'otpVerfiy'])->name('verification.otp.verify');
    Route::post('otp/resetPasswordVerify', [ClientVerificationController::class, 'resetPasswordOtpVerfiy'])->name('verification.otp.resetPassword');
    
    Route::post('reset-password', [ClientVerificationController::class, 'resetPassword'])->name('verification.reset-password');

    Route::post('forgot-password', [ClientVerificationController::class, 'forgotPassword'])->name('client.forgot-password');

    Route::post('login', [ClientAuthController::class, 'login']);
    Route::post('logout', [ClientAuthController::class, 'logout'])->middleware(['jwt.auth',]);

    Route::post('store/save', [StoreController::class, 'store'])->middleware(['jwt.auth', 'is_client_sms_verified']);
    // Route::patch('store/{store}/update', [StoreController::class, 'update'])->middleware(['jwt.auth','is_client_sms_verified']);
    // Route::delete('store/{store}/delete', [StoreController::class, 'destroy'])->middleware(['jwt.auth','is_client_sms_verified']);

    Route::get('states', [ClientStateController::class, 'index'])->middleware(['jwt.auth']);
    Route::get('types', [TypeController::class, 'index'])->middleware(['jwt.auth']);
    Route::get('categories', [CategoryController::class, 'index'])->middleware(['jwt.auth']);

});

Route::group(['prefix' => 'v1/customer','middleware' => ['assign.guard:customer','jwt.auth']],function ()
{
	Route::get('/demo', function(){
        dd(Auth::guard(), 'Customer');
    });		
});









// Route::prefix('v1')->controller(AuthController::class)->group(function () {

//     Route::post('login', 'login');

//     //Route::post('register', 'register');

//     Route::middleware('auth:api')->group(function () {

//         Route::post('logout', 'logout');
//         Route::post('me', 'me');

//     });

// });

// Route::prefix('v1')->controller(StoreController::class)->group(function () {

//     Route::middleware('auth:api')->group(function () {

//         Route::get('store/show/{store}', 'show');
//         Route::post('store/save', 'store');
//         Route::patch('store/{store}/update', 'update');
//         Route::delete('store/{store}/delete', 'destroy');

//     });

// });