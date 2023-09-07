<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapsController;
use Illuminate\Support\Facades\Route;



Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'proses_login')->name('proses_login.login');
    Route::get('/logout', 'logout')->name('logout');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::controller(MapsController::class)->group(function () {
    Route::get('/', 'public_maps')->name('home');
    Route::get('/api/maps/{id}', 'get_map_by_id')->name('maps.get_map_by_id');
    Route::get('/api/maps', 'get_maps')->name('get_maps');
    Route::get('/maps', 'index')->name('maps.index');
    Route::get('/maps/edit/{id}', 'edit')->name('maps.edit');
    Route::get('/maps/create', 'create')->name('maps.create');
    Route::post('/maps/store', 'store')->name('maps.store');
    Route::put('/maps/update/{id}', 'update')->name('maps.update');
});
