<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = ''): Response
    {
        $user = $request->user();
        if ($user->hasRole($role)) {
            return $next($request);
        }

        // Jika tidak memiliki role, tampilkan error 403
        abort(403, 'Forbidden, Kamu tidak punya akses ke halaman ini');
    }
}