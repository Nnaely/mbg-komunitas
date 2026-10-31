<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])
        ->middleware('throttle:5,1');
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::view('/area/pelapor', 'areas.role', ['namaPeran' => 'Pelapor'])
        ->middleware('role:pelapor')
        ->name('area.pelapor');

    Route::view('/area/pemantau', 'areas.role', ['namaPeran' => 'Pemantau'])
        ->middleware('role:pemantau')
        ->name('area.pemantau');

    Route::view('/area/koordinator', 'areas.role', ['namaPeran' => 'Koordinator'])
        ->middleware('role:koordinator')
        ->name('area.koordinator');
});
