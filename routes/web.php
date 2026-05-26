<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\StudentPortalController;
use App\Http\Controllers\Auth\VendorRegisterController; 
use App\Http\Controllers\Web\AdminController; 
use App\Http\Controllers\Web\ManagerPortalController;
// FIXED: Imported your admin controller sitting inside the Web folder path
use App\Http\Controllers\Web\AdminDashboardController; 

/*
|--------------------------------------------------------------------------
| 1. PUBLIC LANDING ENTRYWAY
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [VendorRegisterController::class, 'register'])->name('register.store');

Route::get('/vendor/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
Route::post('/vendor/onboarding', [VendorRegisterController::class, 'register']);

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED SYSTEM BOUNDARY (All users must be logged in)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ROLE 1: UNIVERSITY ADMIN ROUTES
    |--------------------------------------------------------------------------
    | Implements multi-tenant onboarding controls.
    |
    */
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard View (The grid layout network screen)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Deploy/Add New Tenant Form Actions
        Route::get('/canteens/create', [AdminDashboardController::class, 'create'])->name('canteens.create');
        Route::post('/canteens/store', [AdminDashboardController::class, 'store'])->name('canteens.store');
    });

    /*
    |--------------------------------------------------------------------------
    | THE TRAFFIC COP (Default Login Redirect)
    |--------------------------------------------------------------------------
    | Catches Laravel's default post-login redirect and routes the user 
    | to their specific multi-tenant workspace based on their role.
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        } else {
            // Default fallback for students
            return redirect()->route('student.menu'); 
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROLE 2: CANTEEN VENDOR/MANAGER ROUTES
    |--------------------------------------------------------------------------
    | Isolated by 'manager' middleware to prevent student access.
    */
    Route::middleware(['manager'])->group(function () {
        Route::get('/manager/dashboard', [ManagerPortalController::class, 'dashboard'])->name('manager.dashboard');
        Route::get('/manager/orders', \App\Livewire\LiveOrderBoard::class)->name('manager.orders');
        Route::get('/manager/settings', function () { return view('canteen_manager.settings'); })->name('manager.settings');

        Route::resource('/manager/menu', \App\Http\Controllers\Web\MenuController::class)->names([
            'index' => 'manager.menu', 
            'create' => 'manager.menu.create',
            'store' => 'manager.menu.store',
            'edit' => 'manager.menu.edit',
            'update' => 'manager.menu.update',
            'destroy' => 'manager.menu.destroy',
        ]);
    }); 

    /*
    |--------------------------------------------------------------------------
    | ROLE 3: STUDENT PORTAL ROUTES
    |--------------------------------------------------------------------------
    | Mobile-responsive browser ordering interface maps.
    */
    Route::middleware(['student'])->group(function () {
        // 1. Menu views
        Route::get('/student/menu', [StudentPortalController::class, 'menu'])->name('student.menu');
        Route::get('/student/order', [StudentPortalController::class, 'menu']); // Helper alias
        
        // 2. Cart Processing
        Route::post('/student/cart/add/{id}', [StudentPortalController::class, 'addToCart'])->name('student.cart.add');
        Route::get('/student/cart', [StudentPortalController::class, 'viewCart'])->name('student.cart.view');
        Route::post('/student/checkout', [StudentPortalController::class, 'checkout'])->name('student.checkout');
        
        // 3. Order History Tracking
        Route::get('/student/orders', [StudentPortalController::class, 'history'])->name('student.orders');
    });

});