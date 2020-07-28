<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ContactVerification
{
    public function handle($request, \Closure $next)
    {
        $user = auth()->user();
        if ($user->email_verified_at || $user->phone_verified_at ) {
            return $next($request);
        }

        throw new HttpException(Response::HTTP_BAD_REQUEST, 'Contact is not verified!');
    }
}
