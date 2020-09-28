<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected const
        TOURIST_UPLOAD_LIMIT = 2, USER_UPLOAD_LIMIT = 60, ADMIN_AUTH_LIMIT = 30;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initRateLimiter();
    }

    protected function initRateLimiter()
    {
        // 上传限流
        RateLimiter::for('uploads', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(self::USER_UPLOAD_LIMIT)
                : Limit::perMinute(self::TOURIST_UPLOAD_LIMIT);
        });

        // 权限限流
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(self::ADMIN_AUTH_LIMIT);
        });
    }
}
