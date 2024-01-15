<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class MemberAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('account.login');
    }
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('member')->check()) {
            return $this->auth->shouldUse('member');
        }

        $this->unauthenticated($request, ['member']);
    }
}
