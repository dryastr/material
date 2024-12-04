<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = Auth::user()->role; // Mengambil peran pengguna saat ini

        if (in_array($userRole, $roles)) {
            return $next($request);
        } else {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            } else {
                return back()->with('error', 'Opps, Anda tidak dapat mengakses halaman yang dituju!');
            }
        }
    }
}
