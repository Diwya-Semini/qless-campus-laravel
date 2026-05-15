<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController; 

Route::get('/', function () {
    return view('welcome');
});

// Protect the dashboard and menu so only logged-in managers can see them
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard Routes
    // ----------------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/ready', [DashboardController::class, 'markReady'])->name('orders.ready');
    // Menu Routes
    // ----------------------------------------------------
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create'); 
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');      
    // ---------Edit and Update
    Route::get('/menu/{product}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{product}', [MenuController::class, 'update'])->name('menu.update');
    
});