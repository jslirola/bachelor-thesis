<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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

        if ($request->user() && !$request->user()->hasRolGeneral()) {
            return redirect(route('administrator'));
        } elseif (!$request->user()) {
            return redirect(route('index'));
        }

        return $next($request);
    }
}
