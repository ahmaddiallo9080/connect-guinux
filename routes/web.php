<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/* ---------- Site public ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/boutique', [ShopController::class, 'index'])->name('shop.index');
Route::get('/boutique/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

/* ---------- Administration ---------- */
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/connexion', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/connexion', [Admin\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.attempt');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/deconnexion', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', Admin\DashboardController::class)->name('dashboard');

        Route::resource('produits', Admin\ProductController::class)
            ->except('show')
            ->parameters(['produits' => 'product:id'])
            ->names('products');
        Route::patch('produits/{product:id}/visibilite', [Admin\ProductController::class, 'toggle'])->name('products.toggle');

        Route::resource('categories', Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('messages', Admin\MessageController::class)->only(['index', 'show', 'destroy']);
    });
});
