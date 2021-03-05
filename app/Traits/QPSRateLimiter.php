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
    protected string $rateLimiterKey = 'qps:limit:%s:%s';

    /**
     * 校验是否通过
     *
     * @param string $apiName 接口名称或标识
     * @param string $restriction 约束值可以是用户id、用户ip、或id+ip的组合
     * @param int $qps 每秒的请求qps量级
     * @param int $millisecond 毫秒过期时间
     * @return bool true表示通过、false表示触发限流
     */
    public function limit(string $apiName, string $restriction, int $qps = 3, int $millisecond = 1050): bool
    {
        if (empty($apiName) || empty($restriction) || $qps <= 0) {
            return false;
        }

        // 组装key
        $cacheKey = sprintf($this->rateLimiterKey, $apiName, $restriction);
        // 如果长度达到qps限制量级，则触发限流
        if (Redis::llen($cacheKey) > $qps) {
            return true;
        }

        // 如果key储存在，表示第一次请求，则初始化数量和过期时间。否则加一
        if (!Redis::exists($cacheKey)) {
            $redisHandler = Redis::pipeline();
            $redisHandler->rpush($cacheKey, 1);
            $redisHandler->pexpire($cacheKey, $millisecond);
            $redisHandler->exec();
        } else {
            Redis::rpushx($cacheKey, 1);
        }

        return false;
    }
}
