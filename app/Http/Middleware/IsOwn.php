<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Closure;

class IsOwn
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $ability)
    {
        $userRequested = $request->route('user');
        $user = auth()->user();

        if ($userRequested->id === $user->id || Bouncer::can($ability) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        abort(403, "This action is unauthorized.");
    }
}
