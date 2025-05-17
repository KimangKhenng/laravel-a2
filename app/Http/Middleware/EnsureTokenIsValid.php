<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the token is valid
        $token = $request->bearerToken();
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token is invalid'], 401);
        }
        // Check if the token is expired
        if ($decoded->exp < time()) {
            return response()->json(['message' => 'Token expired'], 401);
        }
        $request->attributes->add(['user' => $decoded]);
        return $next($request);
    }
}
