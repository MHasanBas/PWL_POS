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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Mengambil data level_kode dari user yang login
        $user_role = $request->user()->getRoleId(); 

        if (in_array($user_role, $roles)) { // Cek apakah level_kode user ada di dalam array roles
            return $next($request); // Jika ada, maka lanjutkan request
        }

        // Jika tidak punya role, maka tampilkan error 403
        abort(403, 'Forbidden. Kamu tidak punya akses ke halaman ini');
    }
}