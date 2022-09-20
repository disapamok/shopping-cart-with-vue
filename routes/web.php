<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->middleware('guest');

Route::group(['middleware' => 'auth', 'as' => 'front.'], function () {
    Route::get('/', [FrontController::class, 'listProducts'])->name('list');
});

Route::group(['middleware' => 'auth', 'as' => 'cart.', 'prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::delete('/remove-item/{CartItem}', [CartController::class, 'remove'])->name('remove');
    Route::put('/do-checkout', [CartController::class, 'doCheckout'])->name('do-checkout');
    Route::get('/order-history', [CartController::class, 'checkout'])->name('checkout');
});

Route::group(['middleware' => ['auth', 'operation_manager'], 'prefix' => 'products', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('product', 'ProductController');
});

Route::group(['middleware' => ['auth', 'sales_manager'], 'prefix' => 'reports', 'namespace' => 'Report', 'as' => 'reports.'], function () {
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');
    Route::get('/get', [ReportController::class, 'get'])->name('fetch');
});

Route::get('lang-{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Auth::routes();
