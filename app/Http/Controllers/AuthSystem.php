<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthSystem extends Controller
{
    public function login(Request $request) {
        $data = $request->validate([
            "email" => 'required|string|email',
            "password" => 'required|string|max:255'
        ]);

        $user = User::where("email", $data['email'])->first();

        if (!$user) {
            return response()->json([
                "message" => "Email tidak terdaftar."
            ], 404);
        }

        if (Hash::check($data['password'], $user->password)) {
            $token = $user->createToken($request->email)->plainTextToken;
            return response()->json([
                'user_id' => $user['id'],
                'token' => $token
            ]);
        } else {
            return response()
                ->json([
                    "message" => "Password salah"
            ], 401);
        }
    }

    public function register(Request $request) {
        $data = $request->validate([
            "first_name" => 'required|string|max:20',
            "last_name" => 'nullable|string|max:20',
            "email" => 'required|string|email',
            "phone" => 'required|string|max:15',
            "password" => 'required|string|max:255'
        ]);

        $user = User::where("email", $data['email'])->first();

        if ($user) {
            return response()->json([
                "message" => "Email sudah terdaftar."
            ], 302);
        }

        // Buat user baru
        User::create([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"] ?? '',
            "email" => $data["email"],
            "phone" => $data["phone"],
            "password" => Hash::make($data["password"])
        ]);

        return response()->json([
            "message" => "Registrasi berhasil."
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
