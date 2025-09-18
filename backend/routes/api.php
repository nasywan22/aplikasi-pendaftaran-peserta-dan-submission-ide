<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/usercheck', function (Request $request) {
    return response()->json([
        "message" => "Kamu sudah login ngabs!",
        "data" => $request->user()
    ]);
})->middleware('auth:sanctum');
