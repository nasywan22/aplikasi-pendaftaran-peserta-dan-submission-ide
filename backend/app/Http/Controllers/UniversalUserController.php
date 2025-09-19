<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniversalUserController extends Controller
{
    public function register(Request $request) {
        $dataHasilValidasi = $request->validate([
            "nama" => "required|string",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|confirmed",
        ]);

        $nama = $dataHasilValidasi["nama"];
        $email = $dataHasilValidasi["email"];
        $password = $dataHasilValidasi["password"];

        try {
            $user = \App\Models\User::create([
                "name" => $nama,
                "email" => $email,
                "password" => bcrypt($password),
            ]);

            return response()->json([
                "message" => "Akun berhasil dibuat",
                "data" => $user
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat membuat akun",
                "error" => $e->getMessage()
            ], 422);
        }
    }
}
