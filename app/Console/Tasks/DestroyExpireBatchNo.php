<?php


namespace App\Console\Tasks;


use Illuminate\Console\Command;

class DestroyExpireBatchNo extends Command
{
    public const BATCH_NO_KEY = 'batch:no:';

    protected $signature = 'task:destroyExpireBatchNo';

    protected $description = '销毁过期批次号';

    public function handle()
    {
        $start = date('Y-m-d H:i:s');
        $time = strtotime( 'today');
        for ($i = $time - 600; $i >= $time - 86400; $i -= 600) {
            $key = self::BATCH_NO_KEY . date('ymdHi', $i);
            cache()->delete($key);
        }
        log_info(['name' => 'DestroyExpireBatchNo', 'start' => $start, 'end' => date('Y-m-d H:i:s')], 'schedule:run');
    }
}
