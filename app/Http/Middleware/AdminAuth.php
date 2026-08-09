<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->get('admin_logged_in') && (!Auth::check() || !in_array(Auth::user()?->role, ['admin', 'superadmin']))) {
            return redirect()->route('client.login');
        }

        return $next($request);
    }
}
