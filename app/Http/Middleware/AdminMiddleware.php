<?php

namespace TradefiUBA\Http\Middleware;

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

        if (\Auth::check() && \Auth::user()->admin !== "1") {
            return redirect('home');
        }
        return $next($request);
    }
}
