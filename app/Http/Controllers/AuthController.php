<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success($user, 'User registered successfully');
    }

    // Login user and create token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create a new personal access token
        $token = $user->createToken('authToken')->accessToken;

        return $this->success([
            'token' => $token,
            'user' => $user,
        ]);
    }


    // Logout user (Revoke the token)
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->success();
    }

    // Get authenticated user details
    public function user(Request $request)
    {
        return $this->success($request->user());
    }
}
