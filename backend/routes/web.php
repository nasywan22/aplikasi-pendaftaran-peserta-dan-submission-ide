<?php

use Illuminate\Support\Facades\Route;
use  illuminate\Http\Request;

Route::middleware(["guest","throttle:6,1"])->group(function () {
    Route::post('/login', [\App\Http\Controllers\UniversalUserController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\UniversalUserController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/user', fn(Request $request) => Auth::user());
});