<?php

use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/produk/{id}/feedback', [FeedbackController::class, 'index']);
Route::post('/produk/{id}/feedback-post', [FeedbackController::class, 'store']);
