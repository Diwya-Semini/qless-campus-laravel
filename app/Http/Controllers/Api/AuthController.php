<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;                 

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate what the frontend sends
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if the credentials are correct
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        // Find the user and generate a Sanctum Token
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('flutter-mobile-app')->plainTextToken;

        // Send the token back to the frontend
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'user' => $user
        ]);
    }
}