<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\ShopController::class, 'index'])->name('home');
    Route::post('/sale/{product}', [\App\Http\Controllers\SalesController::class, 'store'])->name('sale.store');
    Route::post('/sale/{sale}/cancel', [\App\Http\Controllers\SalesController::class, 'cancel'])->name('sale.cancel');
    Route::get('/sale/download', [\App\Http\Controllers\SalesController::class, 'download'])->name('sale.download');
    Route::get('/sales', [\App\Http\Controllers\SalesController::class, 'index'])->name('sale.index');
    Route::delete('/sale/{sale}', [\App\Http\Controllers\SalesController::class, 'destroy'])->name('sale.show');
    Route::post('/sale/{sale}/restore', [\App\Http\Controllers\SalesController::class, 'restore'])->name('sale.restore');
});
