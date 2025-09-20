<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'throttle:6,1'])
    ->post('/login', [\App\Http\Controllers\UniversalUserController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/user', fn(Request $request) => $request->user());
});