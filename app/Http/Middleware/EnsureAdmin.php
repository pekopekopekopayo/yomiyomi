<?php

namespace App\Http\Middleware;

use App\Exceptions\AdminAccessRequiredException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            throw new AdminAccessRequiredException();
        }

        return $next($request);
    }
}
