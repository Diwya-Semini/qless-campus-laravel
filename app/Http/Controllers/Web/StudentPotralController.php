<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    // 1. Browse All Canteens on Campus
    public function index()
    {
        $canteens = Canteen::orderBy('name', 'asc')->get();
        return view('student_portal.canteens', compact('canteens'));
    }

    // 2. View Isolated Menu Items for a Specific Canteen Tenant
    public function showCanteen($id)
    {
        $canteen = Canteen::findOrFail($id);
        
        // Strictly isolate products by the selected canteen ID
        $products = Product::where('canteen_id', $id)
            ->where('isAvailable', true)
            ->orderBy('category', 'asc')
            ->get();

        return view('student_portal.menu', compact('canteen', 'products'));
    }

    // 3. View Active Order Queues for the logged-in Student
    public function myOrders()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student_portal.orders', compact('orders'));
    }
} 