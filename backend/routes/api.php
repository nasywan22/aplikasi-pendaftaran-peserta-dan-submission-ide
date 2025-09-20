<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'throttle:6,1'])
    ->post('/register', [\App\Http\Controllers\UniversalUserController::class, 'register']);