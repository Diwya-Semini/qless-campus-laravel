<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CanteenController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MenuApiController;

// Public Mobile Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/canteens', [CanteenController::class, 'index']);

// The correct Menu route expecting a canteen_id
Route::get('/canteen/{canteen_id}/menu', [MenuApiController::class, 'index']);

// Secure Routes (Requires Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
});