<?php

namespace App\Http\Middleware;

use Bouncer;
use Closure;

class IsOwn
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
        $userRequested = $request->route('user');
        $user = auth()->user();

        if ($userRequested->id === $user->id || Bouncer::can($ability) || Bouncer::is($user)->a('root')) {
            return $next($request);
        }

        return response([
            "message" => "This action is unauthorized.",
        ], 403);
    }
}
