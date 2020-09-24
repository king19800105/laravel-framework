<?php


namespace App\Console\Tasks;


use App\Components\Queue\QueueClient;
use App\Services\LogService;
use Illuminate\Console\Command;

class OperateLogCustomer extends Command
{
    protected $signature = 'task:operateLogCustomer {--key=}';

    protected $description = '操作日志队列消费者';

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
                $logService->createOperateLog($result);
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

        $extra   = $arr['extra'] ?? [];
        $message = $arr['message'] ?? [];
        $ret     = [
            'module'      => $message['module'] ?? '',
            'exec'        => $message['exec'] ?? '',
            'operated_at' => $arr['datetime'] ?? null,
            'uid'         => $extra['user_id'] ?? 0,
            'ip'          => $extra['ip'] ?? '',
            'api'         => $extra['api'] ?? '',
        ];

        if (!empty($extra['params'])) {
            $ret['params'] = \json_encode($extra['params']);
        }

        return $ret;
    }
}
