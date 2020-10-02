<?php


namespace App\Providers;


use App\Models\Admin;
use App\Models\User;
use App\Observers\AdminObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Admin::observe(AdminObserver::class);
        User::observe(UserObserver::class);
    }

    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\AdminRepository::class, \App\Repositories\Eloquent\AdminRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\UserRepository::class, \App\Repositories\Eloquent\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\ErrorLogRepository::class, \App\Repositories\Eloquent\ErrorLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\OperateLogRepository::class, \App\Repositories\Eloquent\OperateLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\PermissionRepository::class, \App\Repositories\Eloquent\PermissionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Contracts\RoleRepository::class, \App\Repositories\Eloquent\RoleRepositoryEloquent::class);
        //end-binding
    }
}
