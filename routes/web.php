<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api-docs')->group(function () {
    Route::get('/', [SwaggerController::class, 'ui'])->name('api.docs');
    Route::get('/json', [SwaggerController::class, 'getJson'])->name('api.docs.json');
    Route::get('/generate', [SwaggerController::class, 'generateJson'])->name('api.docs.generate');
    Route::delete('/cache', [SwaggerController::class, 'clearCache'])->name('api.docs.cache.clear');
});
