<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\StudentPortalController;
use App\Http\Controllers\Auth\VendorRegisterController; 
use App\Http\Controllers\Web\AdminController; 
use App\Http\Controllers\Web\ManagerPortalController;
use App\Http\Controllers\Web\AdminDashboardController; 

/*
|--------------------------------------------------------------------------
| 1. PUBLIC LANDING ENTRYWAY
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// REMOVED THE OVERRIDE: Let Laravel Breeze/Jetstream handle the standard '/register' route for students naturally!

// Clean isolation for your Canteen Manager Onboarding routes
Route::get('/vendor/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
Route::post('/vendor/onboarding', [VendorRegisterController::class, 'register'])->name('vendor.register.store');

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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
        Route::get('/canteens/create', [AdminDashboardController::class, 'create'])->name('canteens.create');
        Route::post('/canteens/store', [AdminDashboardController::class, 'store'])->name('canteens.store');
        
        Route::delete('/canteens/{id}/cancel', [AdminDashboardController::class, 'destroyCanteen'])->name('canteens.cancel');

        Route::get('/managers', [AdminDashboardController::class, 'platformManagers'])->name('managers');
        Route::post('/managers/{id}/approve', [AdminDashboardController::class, 'approveManager'])->name('managers.approve');
        Route::post('/managers/{id}/reject', [AdminDashboardController::class, 'rejectManager'])->name('managers.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | THE TRAFFIC COP (Default Login Redirect)
    |--------------------------------------------------------------------------
    | Catches Laravel's default post-login redirect and routes the user 
    | to their specific multi-tenant workspace based on their role.
    |
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'manager') {
            if ($user->approval_status === 'pending') {
                return redirect()->route('manager.awaiting-approval');
            } elseif ($user->approval_status === 'rejected') {
                auth()->logout(); // Clean logout so they aren't trapped in an infinite loop
                return redirect()->route('login')->with('error', 'Your registration request was declined.');
            }
            return redirect()->route('manager.dashboard');
        } else {
            // Default fallback for verified students - lands cleanly on the menu
            return redirect()->route('student.menu'); 
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROLE 2: CANTEEN VENDOR/MANAGER ROUTES
    |--------------------------------------------------------------------------
    | Isolated by 'manager' middleware to prevent student access.
    |
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
        
        Route::get('/manager/awaiting-approval', function () {
            return view('canteen_manager.awaiting-approval');
        })->name('manager.awaiting-approval');
    }); 

    /*
    |--------------------------------------------------------------------------
    | ROLE 3: STUDENT PORTAL ROUTES
    |--------------------------------------------------------------------------
    | Mobile-responsive browser ordering interface maps.
    |
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