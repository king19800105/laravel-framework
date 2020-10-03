<?php


namespace App\Http\Middleware;

use Anthony\Breaker\Core\ICircuitBreaker;
use Anthony\Breaker\Core\Option;
use App\Traits\FormatResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 断路器中间件
 * Class CircuitBreaker
 * @package App\Http\Middleware
 */
class CircuitBreaker
{
    use FormatResponse;

    protected const TIMEOUT = 3;

    /**
     * @param Request $request
     * @param \Closure $next
     * @param $name
     * @param null $select
     * @return mixed
     * @throws \Anthony\Breaker\Exception\CircuitBreakerException
     */
    public function handle(Request $request, \Closure $next, $name, $select = null)
    {
        if (null === $select) {
            $select = config('breaker.default');
        }

        $configs = config('breaker.' . $select);
        if (empty($configs)) {
            return $next($request);
        }

        $option = (new Option())
            ->setAppId($name)
            ->setCycleTime($configs['cycle'])
            ->setOpenTimeout($configs['open_timeout'])
            ->setThreshold($configs['threshold'])
            ->setPercent($configs['percent'])
            ->setMinSample($configs['min_sample'])
            ->setLengthen($configs['lengthen'])
            ->setHalfOpenStatusMove($configs['half_op_success'], $configs['half_op_fail']);

        /* @var ICircuitBreaker $breaker */
        $breaker = app(ICircuitBreaker::class, ['option' => $option]);
        // 执行的业务逻辑
        $handler = function () use ($next, $request) {
            return $next($request);
        };
        // 校验执行是否成功
        $checker =  function (JsonResponse $response, float $elapsed) use ($configs) {
            $ret = null !== $response->exception;
            $isTimeout = $elapsed >= self::TIMEOUT;
            return !$ret && !$isTimeout;
        };
        // 断路器打开时返回的数据
        $breakerOpenResponse = response()->json($this->format());
        return $breaker->run($handler, $checker, $breakerOpenResponse);
    }
}
