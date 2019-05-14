<?php

namespace App\Http\Middleware\Ability;

use Bouncer;
use Closure;

class UserCan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $ability)
    {
        $user = auth()->user();

        if (Bouncer::can($ability) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return response([
            "message" => "This action is unauthorized.",
        ], 403);
    }
}
