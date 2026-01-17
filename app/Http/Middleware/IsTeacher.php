<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Teacher relation exist karta hai ya nahi
        if (!auth()->user()->teacher) {
            abort(403, 'Only teachers can access this area.');
        }

        return $next($request);
    }
}
