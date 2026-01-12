<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Route yang dikecualikan dari verifikasi CSRF.
     */
    protected $except = [
        '/midtrans/callback',
    ];
}