<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UniversalUserController extends Controller
{
    public function register(ValidateFormRequest $request): JsonResponse
    {
        $dataHasilValidasi = $request->validated();

        if (!\App\Helpers\RecaptchaHelper::verifyCaptcha($request)) {
            return response()->json([
                "message" => "Captcha tidak valid",
            ], 401);
        }

        $nama = $dataHasilValidasi["nama"];
        $telepon = $dataHasilValidasi["telepon"];
        $email = $dataHasilValidasi["email"];
        $password = $dataHasilValidasi["password"];

        try {
            $user = User::create([
                "name" => $nama,
                "email" => $email,
                "password" => bcrypt($password),
                "nomor_telepon" => $telepon,
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

        if (!\App\Helpers\RecaptchaHelper::verifyCaptcha($request)) {
            return response()->json([
                "message" => "Captcha tidak valid",
            ], 401);
        }

        $dataHasilValidasi = [
            "email"=> $dataHasilValidasi["email"],
            "password"=> $dataHasilValidasi["password"],
        ];

        if (!Auth::attempt($dataHasilValidasi)) {
            return response()->json([
                "message"=> "Kayaknya antara email atau password kamu ada yang salah nih... coba cek lagi",
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            "message" => "Berhasil login! :D",
        ], 200);
    }
}
