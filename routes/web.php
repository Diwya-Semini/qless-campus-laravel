<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\StudentPortalController;
use App\Http\Controllers\Auth\VendorRegisterController; 
use App\Http\Controllers\Web\AdminController; 


// 1. PUBLIC LANDING ENTRYWAY
Route::get('/', function () {
    return view('welcome');
});

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
        // Canteen Dashboard & Approvals
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Add New Canteen (Create)
        Route::get('/admin/canteen/create', [AdminController::class, 'createCanteen'])->name('admin.canteen.create');
        Route::post('/admin/canteen', [AdminController::class, 'storeCanteen'])->name('admin.canteen.store');
        
        // User Directory
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        
        // Remove Manager (Delete)
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
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
        // Live Cooking Queue Lines
        Route::patch('/orders/{order}/ready', [DashboardController::class, 'markReady'])->name('orders.ready');
        
        // Paginated Past Fulfilled Records
        Route::get('/manager/history', [DashboardController::class, 'history'])->name('manager.history');
        
        Route::get('/manager/orders', \App\Livewire\LiveOrderBoard::class)->name('manager.orders');

        Route::get('/manager/dashboard', function () { return view('manager.dashboard'); })->name('manager.dashboard');
        Route::get('/manager/menu', function () { return view('manager.menu'); })->name('manager.menu');
        Route::get('/manager/settings', function () { return view('manager.settings'); })->name('manager.settings');
    });

    /*
    |--------------------------------------------------------------------------
    | ROLE 3: STUDENT PORTAL ROUTES
    |--------------------------------------------------------------------------
    | Mobile-responsive browser ordering interface maps.
    */
    Route::middleware(['student'])->group(function () {
        Route::get('/student/menu', [StudentPortalController::class, 'menu'])->name('student.menu');
        Route::post('/student/cart/add/{id}', [StudentPortalController::class, 'addToCart'])->name('student.cart.add');
        
        // ADD THESE TWO NEW ROUTES:
        Route::get('/student/cart', [StudentPortalController::class, 'viewCart'])->name('student.cart.view');
        Route::post('/student/checkout', [StudentPortalController::class, 'checkout'])->name('student.checkout');
        Route::get('/student/orders', [StudentPortalController::class, 'history'])->name('student.orders');
    }); 

});

// // 3. LARAVEL BREEZE DEFAULT AUTHENTICATION
// // This pulls in all your default login, logout, and password reset logic
// require __DIR__.'/auth.php';