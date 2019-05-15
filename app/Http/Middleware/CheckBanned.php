<?php

namespace App\Http\Middleware;

use Closure;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $message = 'Your account has been suspended. Please contact administrator.';

            if ($request->user()->token()) {
                $request->user()->token()->revoke();
            } else {
                auth()->logout();
            }

            if ($request->wantsJson()) {
                return response()->json(compact('message'), 403);
            } else {
                return redirect()->route('login')->withMessage($message);
            }
        }

        return $next($request);
    }
}
