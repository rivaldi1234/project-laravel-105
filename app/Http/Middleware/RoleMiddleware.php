<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login dan rolenya sesuai
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Jika bukan admin, tolak dengan 403 Forbidden
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized. Hanya Admin yang boleh mengakses rute ini!'
        ], 403);
    }
}