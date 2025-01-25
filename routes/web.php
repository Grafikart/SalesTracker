<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\ShopController::class, 'index'])->name('home');
Route::post('/sale/{product}', [\App\Http\Controllers\ShopController::class, 'store'])->name('sale.store');
Route::post('/sale/{sale}/cancel', [\App\Http\Controllers\ShopController::class, 'cancel'])->name('sale.cancel');
Route::get('/sale/download', [\App\Http\Controllers\ShopController::class, 'download'])->name('sale.download');
Route::get('/sales', [\App\Http\Controllers\ShopController::class, 'sales'])->name('sale.index');
