<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::get('/shorten', [ShortUrlController::class, 'Index']);
Route::post('/shorten', [ShortUrlController::class, 'Store']);
Route::get('/shorten/{short_code}', [ShortUrlController::class, 'Show']);
Route::get('/shorten/{short_code}/stats', [ShortUrlController::class, 'Stats']);
Route::patch('/shorten/{short_code}', [ShortUrlController::class, 'Update']);
Route::delete('/shorten/{short_code}', [ShortUrlController::class, 'Destroy']);
