<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if they are logged in AND if they are an admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request); // Let them pass!
        }

        // If they aren't an admin, kick them back to the home page
        return redirect('/')->with('error', 'Access Denied: You do not have recruiter privileges.');
    }
}