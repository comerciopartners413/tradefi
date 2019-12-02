<?php

namespace TradefiUBA\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // escape central pay's payment gateway
        '/pay',
        '/deposit/pay',
        '/deposit/pay2',
        '/users',
        '/users/create',
    ];
}
