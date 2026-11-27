<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ((int) $user->roles_id !== 3) {
            abort(403, 'Akun ini bukan akun Customer.');
        }

        if (empty($user->email_verified_at)) {
            return redirect()->route('otp.show');
        }

        return $next($request);
    }
}