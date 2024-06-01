<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request){
        return $request->user();
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'max:255', 'confirmed', 'min:8']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid login creds!'
            ], 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => "Logged out"
        ], 201);
    }
}