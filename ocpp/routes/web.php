<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if(\Auth::check()){
        return Inertia::render('dashboard');
    } else{
        return Inertia::render('auth/login');
    }
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
//    Route::get('dashboard', function () {
//        return Inertia::render('dashboard');
//    })->name('dashboard');
});

Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('stations', \App\Http\Controllers\StationController::class);
Route::resource('sites', \App\Http\Controllers\SiteController::class);
Route::get('dashboard', [\App\Http\Controllers\IndexController::class, 'dashboard'])->name('dashboard');
Route::get('homepage', [\App\Http\Controllers\IndexController::class, 'dashboard'])->name('index.dashboard');
Route::get('manage', [\App\Http\Controllers\IndexController::class, 'manage'])->name('index.manage');
Route::any('logs', [\App\Http\Controllers\LogController::class, 'index'])->name('index.log');
Route::any('test/{station}', [\App\Http\Controllers\StationController::class, 'destroy'])->name('test');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
