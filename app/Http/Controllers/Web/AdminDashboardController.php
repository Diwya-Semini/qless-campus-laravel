<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // 1. Render all campus locations in the grid view
    public function index()
    {
        $canteens = Canteen::all();
        return view('admin.dashboard', compact('canteens'));
    }

    // 2. Show the "Deploy Canteen" deployment form layout view
    public function create()
    {
        return view('admin.deploy-canteen');
    }

    // 3. Store a brand new campus tenant inside the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'open_time' => 'required|string',
            'close_time' => 'required|string',
            'status' => 'required|in:open,closed'
        ]);

        Canteen::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'New Canteen Deployed Successfully!');
    }
}