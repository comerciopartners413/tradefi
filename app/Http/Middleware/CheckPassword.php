<?php

namespace TradefiUBA\Http\Middleware;

use Closure;
use Hash;

class CheckPassword
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
        $user = auth()->user();
        if ($user->changed_password == false) {
          return redirect()->route('change_pass')->with('error', 'You must change your password to continue.');
        }
        return $next($request);
    }
}
