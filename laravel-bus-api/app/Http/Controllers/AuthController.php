<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use LDAP\Result;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|confirmed'
        ]);
        $validate['password'] = Hash::make($validate['password']);
        $user = User::create($validate);
        return response()->json([
            'message' => 'create user success',
            'user' => $user
        ], 200);
    }    
    public function login(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required'
        ]);

        $user = User::where('username', $validate['username'])->first();
        if (!$user || !Hash::check($validate['password'], $user->password)) {
            return response()->json(['message' => 'invalid login'],401);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'logout success']);
    }
}
