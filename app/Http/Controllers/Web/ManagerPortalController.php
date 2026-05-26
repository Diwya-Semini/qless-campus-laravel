<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class ManagerPortalController extends Controller
{
    public function dashboard()
    {
        $manager = auth()->user();
        $today = Carbon::today();

        // 1. Calculate Today's Orders
        $totalOrdersToday = Order::where('canteen_id', $manager->canteen_id)
                                 ->whereDate('created_at', $today)
                                 ->count();

        // 2. Calculate Today's Revenue
        $totalRevenueToday = Order::where('canteen_id', $manager->canteen_id)
                                  ->whereDate('created_at', $today)
                                  ->sum('total_amount');

        // 3. Calculate Menu Availability
        $totalProducts = Product::where('canteen_id', $manager->canteen_id)->count();
        $activeMenuItems = Product::where('canteen_id', $manager->canteen_id)
                                  ->where('is_available', true)
                                  ->count();
        $outOfStockItems = $totalProducts - $activeMenuItems;

        // Note: Avg Prep Time requires tracking when an order changes from 'pending' to 'ready'. 
        // We will leave it static for now until we build that specific tracking feature!

        return view('canteen_manager.dashboard', compact(
            'totalOrdersToday', 
            'totalRevenueToday', 
            'totalProducts', 
            'activeMenuItems', 
            'outOfStockItems'
        ));
    }
}