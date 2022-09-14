<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use Closure;

class IsSalesManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id == Roles::SALES_MANAGER) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
