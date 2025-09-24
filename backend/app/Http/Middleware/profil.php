<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class Profil
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $apakahProfilUserAda = \DB::table("profiles")->where("user_id","=", Auth::user()->id)->exists();
            $apakahProfilUserAda = Auth::user() && $apakahProfilUserAda;
            if ($apakahProfilUserAda) {
                return $next($request);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
