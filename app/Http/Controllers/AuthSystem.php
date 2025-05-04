<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthSystem extends Controller
{
    function login(Request $request) {
        $data = $request->validate([
            "email" => 'required|string|email',
            "password" => 'required|string'
        ]);

        $user = User::where("email", $data['email'])->first();

        if (!$user) {
            return response()->json([
                "message" => "Email tidak terdaftar."
            ], 404);
        }

        if (Hash::check($data['password'], $user->password)) {
            return $user->createToken($request->email)->plainTextToken;
        } else {
            return response()
                ->json([
                    "message" => "Password salah"
            ], 401);
        }
    }

    function register(Request $request) {
        $data = $request->validate([
            "nama_depan" => 'required|string|max:25',
            "nama_belakang" => 'nullable|string|max:25',
            "email" => 'required|string|email',
            "no_hp" => 'required|string|max:15',
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
            "nama_depan" => $data["nama_depan"],
            "nama_belakang" => $data["nama_belakang"] ?? '',
            "email" => $data["email"],
            "no_hp" => $data["no_hp"],
            "password" => Hash::make($data["password"])
        ]);

        return response()->json([
            "message" => "Registrasi berhasil."
        ], 201);
    }

    function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
