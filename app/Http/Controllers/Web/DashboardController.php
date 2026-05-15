<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Grab all orders, newest first, and bring the User and Canteen data with them
        $orders = Order::with(['user', 'canteen'])->latest()->get();
        
        // Send this data to the Jetstream dashboard view
        return view('dashboard', compact('orders'));
    }

    public function markReady(Order $order){
        $order->update([
            'status' => 'ready'
        ]);
        return back();
    }
}