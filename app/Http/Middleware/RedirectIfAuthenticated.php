<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);

            $role = auth()->user()->role_id;
            switch ($role) {
                case Roles::ADMIN || $role == Roles::OPERATION_MANAGER:
                    return redirect('/products/dashboard');
                    break;
                case $role == Roles::ADMIN || $role == Roles::OPERATION_MANAGER:
                    return redirect('/reports/dashboard');
                    break;
                default:
                    return redirect('/home');
                    break;
            }
        }

        return $next($request);
    }
}
