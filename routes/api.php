<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CanteenController;
use App\Http\Controllers\Api\OrderController;

// Public Routes
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::get('/canteens', [CanteenController::class, 'index'])->name('api.canteens.index');

// Protected Routes
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', function (Request $request){
        return $request->user();
    })->name('api.user');
    //route to join a queue
    Route::post('/orders', [OrderController::class, 'store'])->name('api.orders.store');
});