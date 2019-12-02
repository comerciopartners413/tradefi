<?php

namespace TradefiUBA\Http\Middleware;

use Closure;

class CheckIpMiddleware
{

  public $white_ips = ['192.168.1.1', '127.0.0.1'];
  public $black_ips = [];
  
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (!in_array($request->ip(), $this->white_ips)) {
        //   return response()->json(['Cannot connect to this resource.']);
        // }

        return $next($request);
    }
}
