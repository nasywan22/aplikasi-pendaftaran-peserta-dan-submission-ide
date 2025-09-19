<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/usercheck', function (Request $request) {
    return response()->json([
        "message" => "Kamu sudah login ngabs!",
        "data" => $request->user()
    ]);
})->middleware('auth:sanctum');

Route::middleware(['guest', 'throttle:6,1'])->group(function () {
    Route::post('/register', [\App\Http\Controllers\UniversalUserController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\UniversalUserController::class, 'login']);
});