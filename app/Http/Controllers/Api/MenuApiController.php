<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class MenuApiController extends Controller
{
    public function index($canteen_id): JsonResponse
    {
        // Notice: isAvailable is spelled exactly like your database column
        $menuItems = Product::where('canteen_id', $canteen_id)
                            ->where('isAvailable', 1) 
                            ->orderBy('category', 'asc')
                            ->get();

        return response()->json($menuItems, 200);
    }
}