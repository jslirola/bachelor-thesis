<?php

namespace App\Http\Middleware;

use Closure;

class TutorMiddleware
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

        if ($request->user() && !$request->user()->hasRolTutor()) {
            return redirect(route('administrator'));
        }

        return $next($request);
    }
}
