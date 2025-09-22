<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Profil
{
    public function handle(Request $request, Closure $next)
    {
        if (!\Auth::user() || !\Auth::user()->user_id) {
            return response()->json([
                "status" => "error",
            ], 401);
        }
        return $next($request);
    }
}
