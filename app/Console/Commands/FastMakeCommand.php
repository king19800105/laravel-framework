<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/**
 * Class FastMakeCommand
 * @package App\Console\Command
 */
class FastMakeCommand extends Command
{
    protected const
        CMD = 'cmd', SUFFIX = 'suffix';

    protected const COMMAND_MAPPING = [
        'rp'   => [self::CMD => 'make:res', self::SUFFIX => '%sResponder'],
        'rq'   => [self::CMD => 'make:request', self::SUFFIX => '%sRequest'],
        'md'   => [self::CMD => 'make:model', self::SUFFIX => ''],
        'ctr'  => [self::CMD => 'make:controller', self::SUFFIX => '%sController'],
        'ob'   => [self::CMD => 'make:observer', self::SUFFIX => '%sObserve'],
        'mf'   => [self::CMD => 'model:filter', self::SUFFIX => ''],
        'cd'   => [self::CMD => 'make:command', self::SUFFIX => ''],
        'plc'  => [self::CMD => 'make:policy', self::SUFFIX => '%sPolicy'],
        'vp'   => [self::CMD => 'vendor:publish', self::SUFFIX => ''],
        'mg'   => [self::CMD => 'migrate', self::SUFFIX => ''],
        'mgt'  => [self::CMD => 'make:migration', self::SUFFIX => 'create_%s_table'],
        'mgr'  => [self::CMD => 'migrate:rollback', self::SUFFIX => ''],
        'sd'   => [self::CMD => 'make:seeder', self::SUFFIX => '%sSeeder'],
        'srv'  => [self::CMD => 'make:service', self::SUFFIX => '%sService'],
        'repo' => [self::CMD => 'make:repo', self::SUFFIX => '%sRepository']
    ];


    protected $signature = 'cmd {type} {result?} {--opt=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速创建模版文件';

    protected $option;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type         = $this->argument('type');
        $result       = $this->argument('result');
        $this->option = $this->option('opt');
        if (!array_key_exists($type, self::COMMAND_MAPPING)) {
            $this->error('Params went wrong!');
            return;
        }

        $arr = self::COMMAND_MAPPING[$type];
        $cmd = trim($this->parseCommand($result, $arr));
        Artisan::call($cmd);
        $this->info('success');
    }

    /**
     * 解析
     *
     * @param $result
     * @param $arr
     * @return string
     */
    protected function parseCommand($result, $arr)
    {
        $opt = '';
        if (null === $result) {
            return $arr[self::CMD];
        }

        $suffix = str_replace('%s', '', $arr[self::SUFFIX]);
        if ('' !== $arr[self::SUFFIX] && !Str::endsWith($result, $suffix)) {
            $result = sprintf($arr[self::SUFFIX], $result);
        }

        if ('null' !== $this->option) {
            $opt = '--' . $this->option;
        }

        return $arr[self::CMD] . ' ' . ucfirst($result) . ' ' . $opt;
    }
}
