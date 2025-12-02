<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas de productos
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Rutas de categorías
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

// Rutas de preferencias
Route::get('/preferences', [PreferenceController::class, 'index'])->name('preferences');
Route::post('/preferences/cookie', [CarritoController::class, 'GuardarCookiePreferencia'])->name('preferences.cookie');
Route::put('/preferences', [PreferenceController::class, 'update'])->name('preferences.update')->middleware('auth');

// Rutas de carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');



