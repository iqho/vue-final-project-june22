<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PaymentMethodApiController;

/* Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']); */
     

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('api-products', ProductApiController::class)->only(['index','show']);

Route::apiResource('api-orders', OrderApiController::class)->only(['index','show','store']);

Route::get('api-categories', [CategoryApiController::class, 'getCategories'])->name('api-category');

Route::get('api-payment-methods', [PaymentMethodApiController::class, 'index'])->name('api-payment-methods');

Route::get('api-category/{category}', [CategoryApiController::class, 'getSingleCategory'])->name('api-single-category');

//API route for register new user
Route::post('/register', [AuthController::class, 'register']);

//API route for login user
Route::post('/login', [AuthController::class, 'login']);