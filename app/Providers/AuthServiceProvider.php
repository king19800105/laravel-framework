<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\AdminPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
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
        Admin::class      => AdminPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class       => RolePolicy::class,
        User::class       => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($auth, $ability) {
            if ($auth instanceof User) {
                return $auth->hasRole(config('manage.vip_name')) ? true : null;
            }

            if ($auth instanceof Admin) {
                return $auth->hasRole(config('manage.super_name')) ? true : null;
            }
        });
    }
}
