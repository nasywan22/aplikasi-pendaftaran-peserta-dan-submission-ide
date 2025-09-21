<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaHelper {
    public static function verifyCaptcha(Request $request)
    {
        $captchaToken = $request->input("g-recaptcha-response");
        
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            "secret" => env("NOCAPTCHA_SECRET"),
            "response" => $captchaToken,
        ]);

        $result = $response->json();

        return $result["success"] ?? false;
    }
}