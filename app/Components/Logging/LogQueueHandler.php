<?php


namespace App\Components\Logging;


use App\Components\Queue\QueueClient;
use Illuminate\Support\Arr;
use Monolog\DateTimeImmutable;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * 日志队列
 * Class LogQueueHandler
 * @package App\Components\Logging
 */
class LogQueueHandler extends AbstractProcessingHandler
{
    public const
        ERROR_LOG_QUEUE_KEY = 'log:err:handler', OPERATE_LOG_QUEUE_KEY = 'log:operate:handler';

    protected $queue;

    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    /**
     * @inheritDoc
     */
    protected function write(array $record): void
    {
        $datetime = time();
        if (!empty($record['datetime']) && $record['datetime'] instanceof DateTimeImmutable) {
            $datetime = $record['datetime']->getTimestamp();
        }

        $breakpoint = 'undefined';
        if (!empty($record['context']) && is_array($record['context'])) {
            $breakpoint = Arr::first($record['context']);
        }

        $queue  = app(QueueClient::class);
        $result = array_merge(Arr::only($record, [
            'message',
            'channel',
            'extra'
        ]), [
            'datetime'   => date('Y-m-d H:i:s', $datetime),
            'breakpoint' => $breakpoint
        ]);

        $cnt = 1;
        $routeParam = route_param();
        if (!empty($routeParam) && is_array($routeParam)) {
            foreach ($routeParam as $key => $item) {
                $result['extra']['api'] = str_replace('{' . $key . '}', $item, $result['extra']['api'], $cnt);
            }
        }

        $msg               = $result['message'];
        $result['message'] = \json_decode($msg, true);
        if (!is_array($result['message'])) {
            $result['message'] = $msg;
        }

        if (static::OPERATE_LOG_QUEUE_KEY === $breakpoint) {
            $queue->push(static::OPERATE_LOG_QUEUE_KEY, $result);
            return;
        }

        $queue->push(static::ERROR_LOG_QUEUE_KEY, $result);
    }
}
