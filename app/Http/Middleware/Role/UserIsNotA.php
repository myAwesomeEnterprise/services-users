<?php

namespace App\Http\Middleware\Role;

use Closure;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserIsNotA
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string   $role
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        $user = auth()->user();

        if (Bouncer::is($user)->notA($role) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return abort(403, "This action is unauthorized.");
    }
}
