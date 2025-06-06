<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
      // Public routes that bypass auth
    if ($request->is('/') || $request->is('public/*')) {
        return null;
    }

    // API error response instead of login redirect
    if ($request->is('api/*')) {
        abort(403, 'Unauthenticated API access');
    }

    // Default login redirect
    return route('login');
    
    }
}
