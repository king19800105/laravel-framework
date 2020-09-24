<?php


namespace App\Console\Tasks;


use Illuminate\Console\Command;


class MyTestTask extends Command
{
    /**
     * 执行案例：task:test 100 --group=demo
     * @var string
     */
    protected $signature = 'task:test {timeout} {--group=}';

    protected $description = '测试指令';

    public function handle()
    {
        $key   = $this->argument('timeout');
        $group = $this->option('group');
        var_dump($key, $group);
    }
}
