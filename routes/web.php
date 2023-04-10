<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| KAFELER Web Routes
|--------------------------------------------------------------------------
*/

# Panel Route
Route::group(['prefix' => 'panel', 'as' => 'panel.'], function () {
    Route::group(['middleware' => ['guest'], 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/register', [\App\Http\Controllers\Back\AuthController::class, 'register'])->name('register');
        Route::get('/login', [\App\Http\Controllers\Back\AuthController::class, 'login'])->name('login');
        Route::post('/register', [\App\Http\Controllers\Back\AuthController::class, 'registerStore'])->name('register.store');
        Route::post('/login', [\App\Http\Controllers\Back\AuthController::class, 'loginStore'])->name('login.store');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', [\App\Http\Controllers\Back\IndexController::class, 'index'])->name('index');
        Route::get('/logout', [\App\Http\Controllers\Back\AuthController::class, 'logout'])->name('auth.logout');

        Route::group(['prefix' => 'cafe', 'as' => 'cafe.'], function () {
            Route::get('/', [\App\Http\Controllers\Back\CafeController::class, 'index'])->name('index');
            Route::get('/detail', [\App\Http\Controllers\Back\CafeController::class, 'show'])->name('show');
            Route::post('/', [\App\Http\Controllers\Back\CafeController::class, 'store'])->name('store');
            Route::post('/update', [\App\Http\Controllers\Back\CafeController::class, 'update'])->name('update');
            Route::delete('/', [\App\Http\Controllers\Back\CafeController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('/', [\App\Http\Controllers\Back\CategoryController::class, 'index'])->name('index');
            Route::get('/detail', [\App\Http\Controllers\Back\CategoryController::class, 'show'])->name('show');
            Route::post('/', [\App\Http\Controllers\Back\CategoryController::class, 'store'])->name('store');
            Route::post('/update', [\App\Http\Controllers\Back\CategoryController::class, 'update'])->name('update');
            Route::delete('/', [\App\Http\Controllers\Back\CategoryController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
            Route::get('/', [\App\Http\Controllers\Back\ProductController::class, 'index'])->name('index');
            Route::get('/detail', [\App\Http\Controllers\Back\ProductController::class, 'show'])->name('show');
            Route::post('/', [\App\Http\Controllers\Back\ProductController::class, 'store'])->name('store');
            Route::post('/update', [\App\Http\Controllers\Back\ProductController::class, 'update'])->name('update');
            Route::delete('/', [\App\Http\Controllers\Back\ProductController::class, 'destroy'])->name('delete');
        });
    });
});

# Home Route
Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index');
Route::get('/{cafe:slug}', [\App\Http\Controllers\Front\IndexController::class, 'cafeDetail'])->name('cafe.detail');
Route::get('/{cafe:slug}/menu', [\App\Http\Controllers\Front\IndexController::class, 'cafeMenu'])->name('cafe.menu');
Route::get('/{cafe:slug}/menu/{productSlug}', [\App\Http\Controllers\Front\IndexController::class, 'cafeProduct'])->name('cafe.product');
