<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Load the dashboard with Pending and Active canteens
    public function dashboard()
    {
        // Fetch every canteen, sorted alphabetically
        $canteens = Canteen::orderBy('name')->get();

        return view('uni_admin.canteens', compact('canteens'));
    }

    // 2. The action to approve a pending canteen
    public function approveCanteen($id)
    {
        $canteen = Canteen::findOrFail($id);
        $canteen->update(['status' => 'approved']);

        return redirect()->back()->with('success', $canteen->name . ' has been approved and is now live on the network!');
    }

    // 3. View the User Directory
    public function users()
    {
        // Get all users who are managers, and eager-load their canteen details
        $managers = User::where('role', 'manager')->with('canteen')->get();

        return view('uni_admin.users', compact('managers'));
    }

        // --- CREATE OPERATION: Show form & Save new Canteen ---

    public function createCanteen()
    {
        return view('uni_admin.create_canteen');
    }

    public function storeCanteen(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'operating_hours' => 'required|string|max:255',
        ]);

        Canteen::create([
            'name'            => $request->name,
            'location'        => $request->location,
            'operating_hours' => $request->operating_hours,
            'is_open'          => 1,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'New Campus Canteen officially added to the network!');
    }


    // --- DELETE OPERATION: Remove a Manager ---
    
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        
        // Delete the user from the database
        $user->delete();

        return redirect()->back()->with('success', "Manager {$name}'s access has been permanently revoked.");
    }
}