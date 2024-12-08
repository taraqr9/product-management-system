<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProductPermissions
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (! auth()->user()->canAny($permissions)) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden: You do not have the required permissions.',
            ], 403);
        }

        return $next($request);
    }
}
