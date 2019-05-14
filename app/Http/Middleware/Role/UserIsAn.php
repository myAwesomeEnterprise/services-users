<?php

namespace App\Http\Middleware\Role;

use Bouncer;
use Closure;

class UserIsAn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = auth()->user();

        if (Bouncer::is($user)->an($role) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return response([
            "message" => "This action is unauthorized.",
        ], 403);
    }
}
