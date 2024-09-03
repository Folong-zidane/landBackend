<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/register', 
        'api/login', 
        'api/loginphone', 
        'api/users/*', 
        'api/lands/*', 
        'api/landImage/*', 
        'api/landVideo/*',
        'api/admin/*', 
        'api/lands/favorite/*', 
        'api/notifications/*', 
        'api/messages/*',
        'api/conversations/*'
    ];
}
