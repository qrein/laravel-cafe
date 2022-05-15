<?php

namespace App\Http\Middleware;

use App\Exceptions\APIException;
use Closure;
use Illuminate\Http\Request;

class UserRoleMiddleware
{

    public function handle(Request $request, Closure $next, $roles)
    {
        dd($request->user());
       /* if (!$request->user()->hasRole(explode('|', $roles))) {
            throw new APIException(403, 'Forbidden for you');
        }*/
        return $next($request);
    }
}
