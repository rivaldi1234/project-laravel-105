<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Public routes (tanpa auth)
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('login',    'App\Http\Controllers\AuthController@login');

    // Protected routes (butuh token Sanctum + rate limit 60 req/menit)
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

        // Categories — semua kecuali delete bisa diakses user biasa
        Route::apiResource('categories',
            'App\Http\Controllers\CategoryController')
            ->except(['destroy']);

        // Categories — delete hanya untuk admin
        Route::delete('categories/{category}',
            'App\Http\Controllers\CategoryController@destroy')
            ->middleware('role:admin');

        // Items — semua kecuali delete bisa diakses user biasa
        Route::apiResource('items',
            'App\Http\Controllers\ItemController')
            ->except(['destroy']);

        // Items — delete hanya untuk admin
        Route::delete('items/{item}',
            'App\Http\Controllers\ItemController@destroy')
            ->middleware('role:admin');
    });
});