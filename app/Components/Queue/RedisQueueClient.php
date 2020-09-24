<?php


namespace App\Components\Queue;

use Illuminate\Redis\RedisManager;

/**
 * Redis队列客户端实现
 * Class RedisQueueClient
 * @package App\Components
 */
class RedisQueueClient implements QueueClient
{
    protected $redis;

    public function __construct(RedisManager $redis)
    {
        $this->redis = $redis;
    }

    /**
     * 入队
     *
     * @param string $key
     * @param $data
     * @param array $options
     * @return mixed
     */
    public function push($key, $data, $options = [])
    {
        $data = $this->formatData($data);
        return $this->redis->lpush($key, $data);
    }

    /**
     * 出队
     *
     * @param $key
     * @return string
     */
    public function pop($key): string
    {
        return $this->redis->rpop($key);
    }

    /**
     * 阻塞类型出队
     *
     * @param $keys
     * @param $timeout
     * @return mixed
     */
    public function blockPop($keys, $timeout)
    {
        return $this->redis->brpop($keys, $timeout);
    }

    /**
     * 延迟队列设置
     * 如果同一个key，数据相同将会失败，建议在数据中添加批次号避免重复
     *
     * @param $key
     * @param $data
     * @param int $delayTime
     * @param array $options
     * @return bool
     */
    public function delayPush($key, $data, $delayTime = 0, $options = [])
    {
        if (!is_int($delayTime) || $delayTime < 0) {
            return false;
        }

        $data = $this->formatData($data);
        return $this->redis->zAdd($key, $delayTime, $data);
    }

    /**
     * 延迟出队
     *
     * @param $key
     * @param $execTime
     * @return array|int|string|null
     */
    public function delayPop($key, $execTime)
    {
        if ($data = $this->redis->zRange($key, 0, 0, true)) {
            $value = key($data);
            $score = $data[$value];
            // 时间没到
            if ($execTime < $score ) {
                return [];
            }
            // 成功出队
            if ($this->redis->zRem($key, $value)) {
                return $value;
            }
        }

        return [];
    }

    /**
     * 集合入队
     *
     * @param $key
     * @param $data
     * @return mixed
     */
    public function sPush($key, $data)
    {
        return $this->redis->sAdd($key, $data);
    }

    /**
     * 集合长度
     *
     * @param $key
     * @return mixed
     */
    public function sPop($key)
    {
        return $this->redis->sPop($key);
    }

    /**
     * 队列长度
     *
     * @param $key
     * @return mixed
     */
    public function length($key)
    {
        return $this->redis->llen($key);
    }

    /**
     * 格式化
     *
     * @param $data
     * @return false|string
     */
    protected function formatData($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }

        if (!is_string($data)) {
            return (string)$data;
        }

        return $data;
    }

    public function ping()
    {
        return $this->redis->ping();
    }
}
