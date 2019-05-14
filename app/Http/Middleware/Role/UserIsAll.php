<?php

namespace App\Http\Middleware\Role;

use Bouncer;
use Closure;

class UserIsAll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $user = auth()->user();
        $isAll = call_user_func_array([Bouncer::is($user), 'all'], $roles);

        if ($isAll || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return response([
            "message" => "This action is unauthorized.",
        ], 403);
    }
}
