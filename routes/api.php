<?php

use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('products', ProductController::class);

Route::get('/stock', [StockController::class, 'index']);
Route::post('/stock', [StockController::class, 'store']);
Route::delete('/stock/{product}', [StockController::class, 'destroy']);
Route::put('/stock/{product}', [StockController::class, 'update']);
Route::get('/stock/{product}', [StockController::class, 'show']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::delete('/cart/{product}', [CartController::class, 'destroy']);
Route::put('/cart/{product}', [CartController::class, 'update']);
Route::get('/cart/{product}', [CartController::class, 'show']);
