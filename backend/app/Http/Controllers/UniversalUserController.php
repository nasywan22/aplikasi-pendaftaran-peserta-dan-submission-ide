<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UniversalUserController extends Controller
{
    public function register(ValidateFormRequest $request): JsonResponse
    {
        $dataHasilValidasi = $request->validated();

        $nama = $dataHasilValidasi["nama"];
        $email = $dataHasilValidasi["email"];
        $password = $dataHasilValidasi["password"];

        try {
            $user = User::create([
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

    public function login(ValidateFormRequest $request): JsonResponse
    {
        $dataHasilValidasi = $request->validated();

        if (!Auth::attempt($dataHasilValidasi)) {
            return response()->json([
                "message"=> "Kayaknya antara email atau password kamu ada yang salah nih... coba cek lagi",
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "message" => "Berhasil login! :D",
            "token" => $token
        ], 200);
    }
}
