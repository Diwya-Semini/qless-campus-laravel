<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Canteen; // Here is our magic import!
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    public function index()
    {
        // Fetch all canteens from the MySQL database
        $canteens = Canteen::all();

        // Return the data packaged as JSON for Flutter
        return response()->json([
            'message' => 'Canteens retrieved successfully',
            'data' => $canteens
        ], 200);
    }
}