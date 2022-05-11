<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\GstProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('login');
});

// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Registration Routes...
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::middleware(['auth','role:admin|employee'])->name('admin.')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('employees/destroyMultiple', [UserController::class, 'destroyMultiple'])->name('employees.destroyMultiple');
    Route::get('/employees/{user}/details', [UserController::class, 'show'])->name('employees.show');
    Route::get('/employees/table', [UserController::class, 'table'])->name('employees.table');
    Route::get('/employees', [UserController::class, 'index'])->name('employees.index');    
    Route::post('/employees', [UserController::class, 'store'])->name('employees.store');
    Route::put('/employees/{user}', [UserController::class, 'update'])->name('employees.update');
    Route::delete('employees/{user}', [UserController::class, 'destroy'])->name('employees.destroy');

    Route::get('client/details/{user}', [ClientController::class, 'details'])->name('clients.details');
    Route::delete('clients/destroyMultiple', [ClientController::class, 'destroyMultiple'])->name('clients.destroyMultiple');
    Route::get('/clients/{user}/details', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/table', [ClientController::class, 'table'])->name('clients.table');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');    
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{user}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/{user}', [ClientController::class, 'destroy'])->name('clients.destroy');
        
    Route::delete('roles/destroyMultiple', [RoleController::class, 'destroyMultiple'])->name('roles.destroyMultiple');
    Route::get('/roles/{role}/details', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/table', [RoleController::class, 'table'])->name('roles.table');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');    
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        
    Route::delete('permissions/destroyMultiple', [PermissionController::class, 'destroyMultiple'])->name('permissions.destroyMultiple');
    Route::get('/permissions/{permission}/details', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/permissions/table', [PermissionController::class, 'table'])->name('permissions.table');    
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');    
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::delete('states/destroyMultiple', [StateController::class, 'destroyMultiple'])->name('states.destroyMultiple');
    Route::get('/states/{state}/details', [StateController::class, 'show'])->name('states.show');
    Route::get('/states/table', [StateController::class, 'table'])->name('states.table');
    Route::get('/states', [StateController::class, 'index'])->name('states.index');    
    Route::post('/states', [StateController::class, 'store'])->name('states.store');
    Route::put('/states/{state}', [StateController::class, 'update'])->name('states.update');
    Route::delete('states/{state}', [StateController::class, 'destroy'])->name('states.destroy');

    Route::delete('cities/destroyMultiple', [CityController::class, 'destroyMultiple'])->name('cities.destroyMultiple');
    Route::get('/cities/{city}/details', [CityController::class, 'show'])->name('cities.show');
    Route::get('/cities/table', [CityController::class, 'table'])->name('cities.table');
    Route::get('/cities', [CityController::class, 'index'])->name('cities.index');    
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::put('/cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

    Route::delete('designations/destroyMultiple', [DesignationController::class, 'destroyMultiple'])->name('designations.destroyMultiple');
    Route::get('/designations/{designation}/details', [DesignationController::class, 'show'])->name('designations.show');
    Route::get('/designations/table', [DesignationController::class, 'table'])->name('designations.table');
    Route::get('/designations', [DesignationController::class, 'index'])->name('designations.index');    
    Route::post('/designations', [DesignationController::class, 'store'])->name('designations.store');
    Route::put('/designations/{designation}', [DesignationController::class, 'update'])->name('designations.update');
    Route::delete('designations/{designation}', [DesignationController::class, 'destroy'])->name('designations.destroy');

    Route::delete('gst-profiles/destroyMultiple', [GstProfileController::class, 'destroyMultiple'])->name('gst-profiles.destroyMultiple');
    Route::get('/gst-profiles/{designation}/details', [GstProfileController::class, 'show'])->name('gst-profiles.show');
    Route::get('/gst-profiles/table', [GstProfileController::class, 'table'])->name('gst-profiles.table');
    Route::get('/gst-profiles', [GstProfileController::class, 'index'])->name('gst-profiles.index');    
    Route::post('/gst-profiles', [GstProfileController::class, 'store'])->name('gst-profiles.store');
    Route::put('/gst-profiles/{designation}', [GstProfileController::class, 'update'])->name('gst-profiles.update');
    Route::delete('gst-profiles/{designation}', [GstProfileController::class, 'destroy'])->name('gst-profiles.destroy');

    Route::get('/settings', [UserController::class, 'showSettings'])->name('settings.index');
    Route::post('/settings', [UserController::class, 'saveSettings'])->name('settings.store');

});




