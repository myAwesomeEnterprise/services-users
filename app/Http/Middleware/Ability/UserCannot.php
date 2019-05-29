<?php

namespace App\Http\Middleware\Ability;

use Closure;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserCannot
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string   $ability
     * @return mixed
     */
    public function handle($request, Closure $next, string $ability)
    {
        $user = auth()->user();

        if (Bouncer::cannot($ability) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return abort(403, "This action is unauthorized.");
    }
}
