<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\Profil;

// autentikasi
Route::middleware(["guest", "throttle:6,1"])->group(function () {
    Route::post('/login', [\App\Http\Controllers\UniversalUserController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\UniversalUserController::class, 'register']);
});

Route::get('/ambildomisili', [\App\Http\Controllers\domisili::class, 'ambilDomisili']);

Route::middleware('auth')->group(function () {
    Route::get('/user', fn() => Auth::user());
    Route::post('/kirimprofil', [\App\Http\Controllers\UniversalUserController::class, 'masukkanDataProfilUser']);
});

Route::middleware(Profil::class)
    ->get("/cekProfil", fn() => response()->json(["message" => "Profil user lengkap"], 200));