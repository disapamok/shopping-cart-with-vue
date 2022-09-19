<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $role = $user->role_id;
        switch ($role) {
            case Roles::ADMIN:
                return redirect('/products/dashboard');
                break;
            case Roles::OPERATION_MANAGER:
                return redirect('/products/dashboard');
                break;
            case Roles::SALES_MANAGER:
                return redirect('/reports/dashboard');
                break;
            default:
                return redirect('/');
                break;
        }
    }
}
