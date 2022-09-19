<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\FrontController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

Route::group(['middleware' => 'admin', 'prefix' => 'products', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('product', 'ProductController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
