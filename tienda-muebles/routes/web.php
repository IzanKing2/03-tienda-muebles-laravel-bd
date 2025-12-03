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
Route::get('/products', [ProductController::class, 'index'])->name('productos.index');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Rutas de categorías
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Rutas de preferencias
Route::get('/preferences', [PreferenceController::class, 'index'])->name('preferences');
Route::put('/preferences', [PreferenceController::class, 'update'])->name('preferences.update');

// Rutas de carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('/carrito/{id}/update', [CarritoController::class, 'updateCantidad'])->name('carrito.update');
Route::delete('/carrito/{id}', [CarritoController::class, 'removeProducto'])->name('carrito.remove');

?>