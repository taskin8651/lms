<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle redirect after login (ROLE BASED)
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return '/admin';
        }

        if ($user->hasRole('Teacher')) {
            return '/teacher/dashboard';
        }

        if ($user->hasRole('Student')) {
            return '/student/dashboard';
        }

        // fallback (safety)
        return '/login';
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
