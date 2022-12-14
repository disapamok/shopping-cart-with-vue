<?php

namespace App\Providers;

use App\Models\Roles;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('touch_product', function (User $user) {
            return in_array($user->role_id, [Roles::ADMIN, Roles::OPERATION_MANAGER]);
        });
        Gate::define('view_reports', function (User $user) {
            return $user->role_id == Roles::SALES_MANAGER;
        });
    }
}
