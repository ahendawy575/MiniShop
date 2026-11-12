<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $username = config('admin.username');
        $password = config('admin.password');

        if (! is_string($username) || $username === '' || ! is_string($password) || $password === ''
            || ! hash_equals($username, (string) $request->getUser())
            || ! hash_equals($password, (string) $request->getPassword())) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED, [
                'WWW-Authenticate' => 'Basic realm="Admin Area"',
            ]);
        }

        return $next($request);
    }
}
