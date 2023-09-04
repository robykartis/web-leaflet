<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'proses_login')->name('proses_login.login');
    Route::get('/logout', 'logout')->name('logout');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::controller(MapsController::class)->group(function () {
    Route::get('/', 'public_index')->name('home');
});
