<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\StudentPortalController;
use App\Http\Controllers\Auth\VendorRegisterController; // <-- Added for SaaS Canteen Onboarding

// 1. PUBLIC LANDING ENTRYWAY
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| PUBLIC SAAS VENDOR ONBOARDING ROUTES
|--------------------------------------------------------------------------

*/
Route::get('/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [VendorRegisterController::class, 'register'])->name('register.store');

Route::get('/vendor/register', [VendorRegisterController::class, 'showRegistrationForm'])->name('vendor.register');
Route::post('/vendor/onboarding', [VendorRegisterController::class, 'register']);

// 2. AUTHENTICATED SYSTEM BOUNDARY (All users must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ROLE 1: UNIVERSITY ADMIN ROUTES
    |--------------------------------------------------------------------------
    | Implements multi-tenant onboarding controls.
    */
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('uni_admin.canteens');
        })->name('admin.dashboard');
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
            return redirect()->route('student.canteens'); 
        }
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROLE 2: CANTEEN VENDOR/MANAGER ROUTES
    |--------------------------------------------------------------------------
    | Isolated by 'manager' middleware to prevent student access.
    */
    Route::middleware(['manager'])->group(function () {
        // Live Cooking Queue Lines
        Route::get('/manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');
        Route::patch('/orders/{order}/ready', [DashboardController::class, 'markReady'])->name('orders.ready');
        
        // Paginated Past Fulfilled Records
        Route::get('/manager/history', [DashboardController::class, 'history'])->name('manager.history');
        
        // Operational Controls & Store Status Switch
        Route::get('/manager/settings', [DashboardController::class, 'settings'])->name('manager.settings');
        Route::post('/manager/settings/toggle', [DashboardController::class, 'toggleStore'])->name('manager.settings.toggle');

        // Complete Menu Catalog CRUD Subsystem
        Route::resource('menu', MenuController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | ROLE 3: STUDENT PORTAL ROUTES
    |--------------------------------------------------------------------------
    | Mobile-responsive browser ordering interface maps.
    */
    // Gateway Displaying Open Campus Canteens
    Route::get('/student/canteens', [StudentPortalController::class, 'index'])->name('student.canteens');
    
    // Isolated Menu Items for the Chosen Tenant Stall
    Route::get('/student/canteen/{id}', [StudentPortalController::class, 'showCanteen'])->name('student.canteen');
    
    // Live Order Progress & Active Queue Tickets tracking
    Route::get('/student/orders', [StudentPortalController::class, 'myOrders'])->name('student.orders');
    
    // Temporary Browser Checkout Session Cart Interfaces
    Route::get('/student/cart', function () { 
        return view('student_portal.cart'); 
    })->name('student.cart');

});

// // 3. LARAVEL BREEZE DEFAULT AUTHENTICATION
// // This pulls in all your default login, logout, and password reset logic
// require __DIR__.'/auth.php';