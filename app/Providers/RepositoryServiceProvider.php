<?php


namespace App\Providers;


use App\Models\Admin;
use App\Observers\AdminObserver;
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
    }

    public function register()
    {
        $this->app->bind(\App\Repositories\Contracts\AdminRepository::class, \App\Repositories\Eloquent\AdminRepositoryEloquent::class);
		//end-binding
    }
}
