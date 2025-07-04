<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
         if (!Auth::check()) {
            return redirect('/login');
        }

        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }
        return $next($request);
    }
}
