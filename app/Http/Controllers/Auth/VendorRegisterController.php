<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Canteen; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

        // 1. Validate the incoming form data
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'canteen_name' => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        // 2. Wrap database inserts in a transaction
        // This ensures if the User fails to create, the Canteen is rolled back too!
        DB::beginTransaction();

        try {
            // Step A: Create the new Campus Canteen Profile
            $canteen = Canteen::create([
                'name'     => $request->canteen_name,
                'location' => $request->location,
                'status'   => 'pending', 
                'operating_hours' => '8:00 AM - 5:00 PM',
            ]);

            // Step B: Create the Manager User linked to the specific Canteen ID
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role'       => 'manager', // Strictly forces the manager role
                'canteen_id' => $canteen->id, // Binds them to their isolated tenant
            ]);

            // 3. Commit the data to MySQL
            DB::commit();

            // 4. Redirect straight to login with a success flash message
            return redirect('/login')->with('success', 'Application submitted successfully! Your account is pending admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}