<?php


namespace App\Components\Logging;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * 自定义日志处理
 * Class CustomLogger
 * @package App\Components\Logging
 */
class CustomLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger(config('app.name'));
        $logger->pushProcessor(new LogProcessor());
        // 写入文件
        if ('production' !== config('app.env')) {
            $logger->pushHandler(new StreamHandler($config['path'], Logger::DEBUG));
            return $logger;
        }

        // 写入队列
        $logger->pushHandler(new LogQueueHandler());
        return $logger;
    }
}
