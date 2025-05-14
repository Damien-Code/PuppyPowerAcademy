<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * @author Damien-COde
     * Check to what the role_id from auth user is equal to
     * if not role_id of 1, then abort with 403
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->user()->role_id != 1) {
            abort(403);
        }
        return $next($request);
    }
}
