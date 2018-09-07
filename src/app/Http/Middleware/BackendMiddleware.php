<?php

namespace App\Http\Middleware;

use Closure;

class BackendMiddleware
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

        if ($request->user() && !$request->user()->hasRolBackend()) {
            return redirect('/');
        } elseif (!$request->user()) {
            return redirect(route('index'));
        }

        return $next($request);
    }
}
