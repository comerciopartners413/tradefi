<?php

namespace TradefiUBA\Http\Middleware;

use Closure;

class CheckPinMiddleware
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
      // dd(auth()->user()->admin);

        $pin_has_changed = auth()->user()->changed_pin;
        if ($pin_has_changed || (auth()->user()->admin)) {
            return $next($request);
        } else {
            return redirect('/change-pin')->with('info', 'Please Set Your Trading Pin to continue');
        }

    }
}
