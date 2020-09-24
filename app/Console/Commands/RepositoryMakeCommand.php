<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class RepositoryMakeCommand extends Command
{

    protected const BASE_NAMESPACE = 'App\\Repositories\\';

    protected const FILE_LIST = ['contracts', 'eloquent'];

    protected const BINDING_FLG = '//end-binding';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string
     */
    protected $type = 'Repository';

    /**
     * 文件对象
     *
     * @var Filesystem
     */
    protected $file;

    /**
     * @var string
     */
    protected $data;

    /**
     * RepositoryMakeCommand constructor.
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * 获取文件信息
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->data = $this->argument('data'); // // AtRepository
        foreach (static::FILE_LIST as $key => $item) {
            $data = $this->getInfoMapping($item);
            $this->parseStub($data[$key]);
        }

        $this->bind();
    }


    protected function parseStub($stub)
    {
        $content = $this->file->get($stub['stub']);
        foreach ($stub['tags'] as $key => $item) {
            $content = str_replace($key, $item, $content);
            $this->file->put($stub['path'], $content);
        }
    }

    protected function bind()
    {
        $vars         = $this->getBindVars();
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        $content      = $this->file->get($providerPath);
        $replace      = sprintf('$this->app->bind(%s, %s);' . PHP_EOL . "\t\t" . static::BINDING_FLG, $vars['interface'], $vars['instance']);
        $content      = str_replace(static::BINDING_FLG, $replace, $content);
        $this->file->put($providerPath, $content);
    }

    /**
     * 获取模版
     *
     * @param $name
     * @return array
     */
    protected function getInfoMapping($name)
    {
        $baseDir = __DIR__ . '/../../../' . lcfirst(str_replace('\\', '/', static::BASE_NAMESPACE));
        return [
            [
                'stub' => __DIR__ . '/stubs/' . $name . '.stub',
                'tags' => [
                    '{{interface}}' => $this->data,
                    '{{namespace}}' => static::BASE_NAMESPACE . ucfirst($name),
                ],
                'path' => $baseDir . ucfirst($name) . '/' . $this->data . '.php'
            ],
            [
                'stub' => __DIR__ . '/stubs/' . $name . '.stub',
                'tags' => [
                    '{{class}}'     => $this->data . ucfirst($name),
                    '{{namespace}}' => static::BASE_NAMESPACE . ucfirst($name),
                    '{{model}}'     => Str::before($this->data, $this->type),
                    '{{interface}}' => $this->data,
                    '{{baseclass}}' => 'Base' . $this->type
                ],
                'path' => $baseDir . ucfirst($name) . '/' . $this->data . ucfirst($name) . '.php'
            ]
        ];
    }

    protected function getBindVars()
    {
        return [
            'interface' => '\\' . static::BASE_NAMESPACE . 'Contracts\\' . $this->data . '::class',
            'instance'  => '\\' . static::BASE_NAMESPACE . 'Eloquent\\' . $this->data . 'Eloquent::class',
        ];
    }

}
