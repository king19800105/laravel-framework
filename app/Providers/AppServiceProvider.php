<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected const
        DEFAULT_LIMIT = 60, MAX_LIMIT = 200, MID_LIMIT = 30, MIN_LIMIT = 10;

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
                ? Limit::perMinute(self::DEFAULT_LIMIT)
                : Limit::perMinute(self::MIN_LIMIT);
        });

        // 权限限流
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(self::MID_LIMIT);
        });

        // 登入限流
        RateLimiter::for('userLogin', function (Request $request) {
            $mobile = $request->mobile ?? '';
            if ($mobile) {
                return Limit::perMinute(self::MIN_LIMIT)->by($mobile);
            }

            return Limit::perMinute(self::DEFAULT_LIMIT)->by($request->getClientIp());
        });

        RateLimiter::for('id', function (Request $request) {
            $id = optional($request->user())->id ?? '';
            if ($id) {
                return Limit::perMinute(self::DEFAULT_LIMIT)->by($id);
            }

            return Limit::perMinute(self::MIN_LIMIT)->by($request->getClientIp());
        });
    }
}
