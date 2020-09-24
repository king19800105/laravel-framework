<?php


namespace App\Console\Tasks;


use App\Services\LogService;
use Illuminate\Console\Command;
use App\Components\Queue\QueueClient;


/**
 * Class ErrorLogCustomer
 * @package App\Console\Tasks
 */
class ErrorLogCustomer extends Command
{
    protected $signature = 'task:errorLogCustomer {--key=}';

    protected $description = '错误日志队列消费者';

    public function handle(QueueClient $queue, LogService $logService)
    {
        $key = $this->option('key');
        while (true) {
            $result = $queue->pop($key);
            if (empty($result)) {
                break;
            }

            $result = $this->format($result);
            if (false === $result) {
                continue;
            }

            try {
                $logService->createErrorLog($result);
            } catch (\Throwable $e) {

            }
        }
    }

    protected function format($result)
    {
        $arr = json_to_arr($result);
        if (false === $arr) {
            return false;
        }

        $extra = $arr['extra'] ?? [];
        $ret   = [
            'message'    => $arr['message'] ?? '',
            'breakpoint' => $arr['breakpoint'] ?? '',
            'channel'    => $arr['channel'] ?? '',
            'request_at' => $arr['datetime'] ?? null,
            'uid'        => $extra['user_id'] ?? 0,
            'ip'         => $extra['ip'] ?? '',
            'api'        => $extra['api'] ?? '',
        ];

        if (is_array($ret['message'])) {
            $ret['message'] = \json_encode($ret['message']);
        }

        if (is_string($ret['message'])) {
            $ret['message'] = trim($ret['message']);
        }

        if (!empty($extra['params'])) {
            $ret['params'] = \json_encode($extra['params']);
        }

        return $ret;
    }

}
