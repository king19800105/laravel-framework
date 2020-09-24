<?php

namespace App\Console;

use App\Components\Logging\LogQueueHandler;
use App\Console\Tasks\ErrorLogCustomer;
use App\Console\Tasks\MyTestTask;
use App\Console\Tasks\OperateLogCustomer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ErrorLogCustomer::class,
        OperateLogCustomer::class,
        MyTestTask::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $errQueueKey = LogQueueHandler::ERROR_LOG_QUEUE_KEY;
        $optQueueKey = LogQueueHandler::OPERATE_LOG_QUEUE_KEY;
        $schedule
            ->command("task:errorLogCustomer --key=${errQueueKey}")
            ->everyMinute()
            ->runInBackground();
        $schedule
            ->command("task:operateLogCustomer --key=${optQueueKey}")
            ->everyMinute()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
