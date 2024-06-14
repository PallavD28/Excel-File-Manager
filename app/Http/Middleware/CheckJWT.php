<?php

namespace App\Http\Middleware;

use Closure;

class CheckJWT
{
    public function handle($request, Closure $next)
    {
        $token = session()->get('jwt_token');

        if (!$token) {
            return redirect('/login');
        }

        // You can decode and verify the token if necessary

        return $next($request);
    }
}
