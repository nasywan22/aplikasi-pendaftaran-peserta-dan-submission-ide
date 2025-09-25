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
    Route::post('/logout', [\App\Http\Controllers\UniversalUserController::class,'logout']);
});

Route::middleware([Profil::class])->group(function () {
    Route::get("/cekProfil", fn() => response()->json(["message" => "Profil user lengkap"], 200));
    Route::get('/ambilprofil', [\App\Http\Controllers\UniversalUserController::class, 'ambilDataProfilUser']);
    Route::middleware('throttle:5,1')->post('/kiriminovasi', [\App\Http\Controllers\form::class,'kirimInovasi']);
});