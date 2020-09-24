<?php


namespace App\Components\Queue;

/**
 * 队列客户端接口
 * Interface QueueClient
 * @package App\Components\Contract
 */
interface QueueClient
{
    public function push($key, $data, $options = []);

    public function pop($key);

    public function blockPop($keys, $timeout);

    public function delayPush($key, $data, $delayTime = 0);

    public function delayPop($key, $execTime);

    public function sPush($key, $data);

    public function sPop($key);

    public function length($key);

    public function ping();
}
