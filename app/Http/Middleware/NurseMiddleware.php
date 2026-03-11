<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NurseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // بنشيك لو مفيش يوزر أو الـ role مش nurse
        if (!$user || $user->role !== 'nurse')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied. Only nurses allowed.'
            ], 403);
        }

        return $next($request);
    }
}
