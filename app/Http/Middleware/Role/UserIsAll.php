<?php

namespace App\Http\Middleware\Role;

use Closure;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserIsAll
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  array    $roles
     * @return mixed
     */
    public function handle($request, Closure $next, array $roles)
    {
        $user = auth()->user();
        $isAll = call_user_func_array([Bouncer::is($user), 'all'], $roles);

        if ($isAll || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return abort(403, "This action is unauthorized.");
    }
}
