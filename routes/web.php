<?php

use App\Http\Controllers\SesionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/panel');

Route::middleware('guest')->group(function () {
    Route::get('/iniciar-sesion', [SesionController::class, 'create'])->name('login');
    Route::post('/iniciar-sesion', [SesionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::view('/panel', 'panel')->name('panel');
    Route::post('/cerrar-sesion', [SesionController::class, 'destroy'])->name('logout');
});
