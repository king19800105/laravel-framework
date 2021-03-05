<?php


namespace App\Http\Middleware;


use App\Exceptions\SystemException;
use App\Traits\QPSRateLimiter;
use Illuminate\Http\Request;

class RateLimiter
{
    use QPSRateLimiter;

    public function handle(Request $request, \Closure $next, $name = null)
    {
        // todo... 如果name为空，根据请求的路由，生成一个uniqueid
        $userId = optional($request->user())->id();
        if (!$this->limit('hello', 10)) {
            return $next($request);
        }

        throw new SystemException('触发限流，类型');
    }
}
