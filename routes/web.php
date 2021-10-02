<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => ['jwt.test']], function () {
    Route::get('/login', function () {
        if (Session::get('logged_in') != 1) {
            return view('login');
        } else {
            return redirect('/');
        }
    });

    Route::get('/register', function () {
        if (Session::get('logged_in') != 1) {
            return view('signup');
        } else {
            return redirect('/');
        }
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('store', [StoreController::class, 'store']);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        // Route::resource('store', StoreController::class);
    });

    Route::get('/', [StoreController::class, 'index']);
    Route::get('/store/{id}', [StoreController::class, 'show']);
    Route::get('/store', [StoreController::class, 'index']);
    Route::resource('cart', CartController::class);
});
