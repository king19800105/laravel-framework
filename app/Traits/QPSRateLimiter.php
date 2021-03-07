<?php


namespace App\Traits;


use Illuminate\Support\Facades\Redis;

/**
 * 秒级限流器
 *
 * Trait QPSRateLimiter
 * @package App\Traits
 */
trait QPSRateLimiter
{

    /**
     * 缓存key
     *
     * @var string
     */
    protected static string $rateLimiterKey = 'qps:limit:%s:%s';

    protected static string $luaScript = <<<'LUA'
local curr = redis.call("INCR",KEYS[1])
if curr == 1
then
    redis.call('PEXPIRE', KEYS[1], ARGV[1])
end
return curr
LUA;

    /**
     * 校验是否触发限流
     *
     * @param string $apiName 接口名称或标识
     * @param string $restriction 约束值可以是用户id、用户ip、或id+ip的组合
     * @param int $qps 每秒的请求qps量级
     * @param int $millisecond 毫秒过期时间
     * @return bool true触发限流、false表示通过
     */
    public function limit(string $apiName, string $restriction, int $qps = 2, int $millisecond = 1050): bool
    {
        if (empty($apiName) || empty($restriction) || $qps <= 0) {
            return false;
        }

        // 组装key
        $cacheKey = sprintf(self::$rateLimiterKey, $apiName, $restriction);
        $callResult = Redis::eval(self::$luaScript, 1, $cacheKey, $millisecond);
        return $callResult > $qps;
    }
}
