<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorRegisterController extends Controller
{
    /**
     * Display the SaaS vendor onboarding form.
     */
    public function showRegistrationForm()
    {
        // Points to resources/views/auth/register.blade.php
        return view('auth.register'); 
    }

    /**
     * Process the vendor registration and create the multi-tenant endpoint.
     */
    public function register(Request $request)
    {
        // 1. Validate the incoming form fields (No canteen_id requested from user!)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'location' => 'required|string|max:255',       // e.g., "Malabe"
            'canteen_name' => 'required|string|max:255',   // e.g., "Food Court"
        ]);

        // 2. Wrap execution inside a transaction so nothing gets half-created if something goes wrong
        DB::transaction(function () use ($request) {
            
            // STEP A: Create the new Canteen outlet dynamically
            // Combining the campus location prefix for standard naming style (e.g. "SLIIT - Food Court")
            $fullCanteenName = $request->location . ' - ' . $request->canteen_name;
            
            $canteen = Canteen::create([
                'name' => $fullCanteenName,
                'location' => $request->location,
                'operating_hours' => '8:00 AM - 6:00 PM', // Default operational placeholder
                'is_open' => 0,                           // Closed until Admin validates them!
            ]);

            // STEP B: Grab that auto-generated ID and attach it to the new manager user record
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'manager',
                'approval_status' => 'pending',           // Needs Admin approval check!
                'canteen_id' => $canteen->id,             // <-- AUTOMATICALLY INJECTED HERE!
            ]);

            // STEP C: Authenticate them right into their pending session portal view
            auth()->login($user);
        });

        // 3. Hand control off to the routing traffic cop middleware we developed earlier
        return redirect('/dashboard')->with('status', 'Registration successful! Your application has been submitted to the university administrator for approval.');
    }
}