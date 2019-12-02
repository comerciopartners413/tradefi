<?php

namespace TradefiUBA\Http\Middleware;

use Closure;

class checkUserSession
{
    public function handle($request, Closure $next)
    {
        $userhash  = \Session::get('userhash');
        $sessionId = \Session::getId();

        if (!auth()->guest() && auth()->user()->user_hash != $userhash) {
            \Session::getHandler()->destroy($sessionId);
            return redirect()->intended($request->getUri());
        }

        return $next($request);
    }
}
