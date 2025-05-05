<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Rutas de autenticación
Auth::routes();

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de productos (CRUD)
Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});
