<?php

/**
 * 获取pathinfo模式路由中的参数或参数列表
 */

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;


if (!function_exists('json_to_arr')) {
    function json_to_arr($strJson)
    {
        if (empty($strJson) || !is_string($strJson)) {
            return false;
        }

        $arr = \json_decode($strJson, true);
        if (\json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $arr;
    }
}


if (!function_exists('convert_storage_to_pub')) {
    function convert_storage_to_pub($storageUrl, $baseUrl)
    {
        if (empty($storageUrl)) {
            return '';
        }

        return rtrim($baseUrl, '/') . '/storage' . Str::after($storageUrl, 'public');
    }
}

if (!function_exists('route_param')) {
    function route_param(string $name = null)
    {
        $route = request()->route();
        if (!is_null($name) && !empty($route)) {
            return $route->hasParameter($name) ? $route->parameter($name) : '';
        }

        return optional($route)->parameters() ?? [];
    }
}

if (!function_exists('send_email')) {
    /**
     * 发送email
     *
     * @param array $params 内容数组替换模板
     * @param string|array $users 用户列表，发给谁
     * @param string $template 选用的模板
     * @param string $title 发送的标题
     */
    function send_email($users, array $params, string $title = '', string $template = 'emails.default')
    {
        if ('' === $title) {
            $title = config('app.name', '');
        }

        Mail::send($template, $params, function ($message) use ($users, $title) {
            if (is_string($users) && !empty($users)) {
                $message->to($users)->subject($title);
                return;
            }

            foreach ($users as $item) {
                $message->to($item);
            }

            $message->subject($title);
        });
    }
}


/**
 * 批量整合
 */
if (!function_exists('batch_merge')) {
    function batch_merge(array $resource, int $oneTime, Closure $callback)
    {
        $result   = [];
        $count    = count($resource);
        $totalNum = (int)ceil($count / $oneTime);

        for ($i = 0; $i < $totalNum; $i++) {
            $nextStart = $i * $oneTime;
            $time      = $oneTime + $nextStart;

            if ($time > $count) {
                $time = $count;
            }

            $result[] = $callback($nextStart, $time);
        }

        return $result;
    }
}

/**
 * 获取业务流水号
 *
 * @param string $prefix 前缀
 *
 * @return string
 */
if (!function_exists('business_id')) {
    function business_id($prefix = '')
    {
        [, $sec] = explode(" ", microtime());
        return $prefix . hash('sha1', uniqid() . $sec);
    }
}


if (!function_exists('hit_key')) {
    /**
     * 抽奖几率
     * @param array $proArr 抽奖数据和几率 [a=>25, b=>75]
     * @param bool $strict 是否严格等份数为100
     * @return bool|int|string
     */
    function hit_key(array $proArr, bool $strict = false)
    {
        $result = '';
        $proSum = array_sum($proArr);
        if ($strict && 100 !== $proSum) {
            return false;
        }

        foreach ($proArr as $key => $item) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $item) {
                $result = $key;
                break;
            } else {
                $proSum -= $item;
            }
        }

        return $result;
    }
}


if (!function_exists('double_avg')) {
    /**
     * 双倍均值算法
     * 用于红包分发等计算
     *
     * @param int $cnt 红包短个数
     * @param int $amount 总金额
     * @return int
     */
    function double_avg(int $cnt, int $amount): int
    {
        // 最小值是1分钱
        $min = 1;
        if ($amount <= 0 || $cnt <= 0 || $amount < $min * $cnt) {
            return 0;
        }

        if ($cnt === $amount) {
            return $min;
        }

        if (1 === $cnt) {
            return $amount;
        }

        // 最大值计算
        $max = $amount - ($min * $cnt);
        $avg = 2 * ($max / $cnt) + $min;

        return rand(0, $avg) + $min;
    }
}


/**
 * 获取类短命名
 */
if (!function_exists('short_name')) {
    function short_name($className)
    {
        if (is_null($className)) {
            return $className;
        }

        return class_basename(get_class($className));
    }
}

/**
 * 加锁操作
 */
if (!function_exists('lock')) {
    /**
     * 加锁
     *
     * @param $key
     * @param $expire
     * @param $owner
     * @return bool
     * @throws LockTimeoutException
     */
    function lock($key, $expire, $owner)
    {
        if (!Cache::lock($key, $expire, $owner)->get()) {
            throw new LockTimeoutException();
        }

        return true;
    }
}

/**
 * 解锁操作
 */
if (!function_exists('unlock')) {
    /**
     * 解锁
     *
     * @param $key
     * @param $expire
     * @param $owner
     */
    function unlock($key, $expire, $owner)
    {
        return Cache::lock($key, $expire, $owner)->release();
    }
}

/**
 * 任意数据转换成字符串
 */
if (!function_exists('data_to_string')) {
    function data_to_string($data)
    {
        if (is_array($data) || is_object($data)) {
            return json_encode($data);
        }

        if (!is_string($data)) {
            return (string)$data;
        }

        return $data;
    }
}

/**
 * 压缩数据
 */
if (!function_exists('compress')) {
    /**
     * 压缩
     *
     * @param string $data
     * @param int $level
     * @return false|string
     */
    function compress(string $data, $level = -1)
    {
        return gzdeflate($data, $level);
    }
}

/**
 * 解压缩
 */
if (!function_exists('uncompress')) {
    /**
     * 解压缩
     *
     * @param string $data
     * @param int $length
     * @return false|string
     */
    function uncompress(string $data, $length = 0)
    {
        return gzinflate($data, $length);
    }
}


/**
 * log日志
 */
if (!function_exists('log_info') && !function_exists('log_error')) {
    function log_info($message, $breakpoint)
    {
        $message = data_to_string($message);
        Log::info($message, ['breakpoint' => $breakpoint]);
    }

    function log_error($message, $breakpoint)
    {
        $message = data_to_string($message);
        Log::Error($message, ['breakpoint' => $breakpoint]);
    }
}

/**
 * 清理缓存
 */
if (!function_exists('clear_all_cache')) {
    function clear_all_cache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('clear-compiled');
    }
}

/**
 * 删除null数据
 */
if (!function_exists('delete_null')) {
    function delete_null(array $data)
    {
        if (empty($data)) {
            return [];
        }

        foreach ($data as $key => $item) {
            if (null === $item) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}


