<?php

use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
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
    return view('index');
});

Auth::routes();

Route::middleware(['auth','role:admin|employee'])->name('admin.')->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('employees/destroyMultiple', [UserController::class, 'destroyMultiple'])->name('employees.destroyMultiple');
    Route::get('/employees/{user}/details', [UserController::class, 'show'])->name('employees.show');
    Route::get('/employees/table', [UserController::class, 'table'])->name('employees.table');
    Route::get('/employees', [UserController::class, 'index'])->name('employees.index');    
    Route::post('/employees', [UserController::class, 'store'])->name('employees.store');
    Route::put('/employees/{user}', [UserController::class, 'update'])->name('employees.update');
    Route::delete('employees/{user}', [UserController::class, 'destroy'])->name('employees.destroy');

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

    Route::get('/settings', [UserController::class, 'showSettings'])->name('settings.index');
    Route::post('/settings', [UserController::class, 'saveSettings'])->name('settings.store');

});




