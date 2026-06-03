<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller 
{
    public function register(Request $req) 
    {
        // 1. Validasi input dari Postman
        $validated = $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 2. Membuat user baru di database (Pastikan ada tanda sama dengan '=' setelah variabel $user)
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Membuat token Sanctum (Pastikan ada tanda sama dengan '=' setelah variabel $token)
        $token = $user->createToken('api-token')->plainTextToken;

        // 4. Mengembalikan respons sukses ke Postman
        return response()->json([
            'status'  => 'success',
            'data'    => [
                'user'  => $user, 
                'token' => $token
            ],
            'message' => 'User registered'
        ], 201);
    }

    public function login(Request $req) 
    {
        $req->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $req->email)->first();

        if (!$user || !Hash::check($req->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        // Hapus token lama agar tidak menumpuk
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'data'    => [
                'user'  => $user, 
                'token' => $token
            ],
            'message' => 'User logged in'
        ]);
    }
}