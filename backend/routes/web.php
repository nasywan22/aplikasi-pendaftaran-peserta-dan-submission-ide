<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\Profil;

// autentikasi
Route::middleware(["guest", "throttle:6,1"])->group(function () {
    Route::post('/login', [\App\Http\Controllers\UniversalUserController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\UniversalUserController::class, 'register']);
});

// cek user
Route::get('/user', fn() => Auth::user())
    ->middleware('auth');

Route::middleware(Profil::class)
    ->get("/cekProfil", fn() => response()->json(["message" => "Profil user lengkap"], 200));
// =============================================================================================