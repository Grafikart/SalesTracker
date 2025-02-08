<?php

use Illuminate\Support\Facades\Route;

$app = function () {
    return view('app');
};

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::middleware(['auth'])->group(function () use ($app) {
    Route::get('/', $app)->name('home');
    Route::get('/orders', $app)->name('sale.index');

    // API
    Route::prefix('api')->group(function () {
        Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
        Route::get('/download', [\App\Http\Controllers\Api\OrderController::class, 'download']);
        Route::post('/orders', [\App\Http\Controllers\Api\OrderController::class, 'store']);
        Route::get('/orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
        Route::delete('/orders/{order}', [\App\Http\Controllers\Api\OrderController::class, 'destroy']);
    });
});
