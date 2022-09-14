<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
