<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ManagerPortalController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $canteenId = $user->canteen_id; 

        // 1. Calculate Core Numeric Indicators
        $totalOrdersToday = Order::where('canteen_id', $canteenId)->whereDate('created_at', Carbon::today())->count();
        
        // FIXED: Changed 'total_price' to 'total_amount' (or your exact column name)
        $totalRevenueToday = Order::where('canteen_id', $canteenId)->whereDate('created_at', Carbon::today())->sum('total_amount');
        
        $totalProducts = Product::where('canteen_id', $canteenId)->count();
        $activeMenuItems = Product::where('canteen_id', $canteenId)->where('is_available', 1)->count();
        $outOfStockItems = Product::where('canteen_id', $canteenId)->where('is_available', 0)->count();

        // 2. Fetch Weekly Revenue Analytics Loop (Past 7 Days)
        $weeklyData = Order::where('canteen_id', $canteenId)
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                DB::raw('SUM(total_amount) as revenue') // FIXED: Changed 'total_price' to 'total_amount' here too
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->pluck('revenue', 'date')
            ->toArray();

        // 3. Build Ordered Alignment Matrices for Frontend Injection
        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $dateKey = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayLabel = Carbon::now()->subDays($i)->format('D (m/d)'); 
            
            $chartLabels[] = $displayLabel;
            $chartValues[] = $weeklyData[$dateKey] ?? 0; 
        }

        return view('canteen_manager.dashboard', compact(
            'totalOrdersToday',
            'totalRevenueToday',
            'activeMenuItems',
            'totalProducts',
            'outOfStockItems',
            'chartLabels',
            'chartValues'
        ));
    }
}