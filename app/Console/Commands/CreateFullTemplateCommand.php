<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateFullTemplateCommand extends Command
{
    protected const CREATE_METHOD = [
        'createTable',
        'createRepository',
        'createRequest',
        'createResponder',
        'createController',
        'createService',
        'createModel',
        'createMessage'
    ];

    protected const TEMP_SUFFIX = '_full.stub';

    protected const DB_TABLE_NAME = 'create_%s_table';

    protected const BINDING_FLG = '//end-field';

    /**
     * name 应用名称
     * rewrite 是否覆盖当前已经创建的文件,
     * config 指定配置文件来读取配置信息，
     * except 排除操作，用于创建和回滚时，指定要排除的文件类型（全小写，如：--except=table,request）
     * fields 指定要生成的字段，如：--fields=name:用户姓名,age:用户年龄
     */
    protected $signature = 'full {--name=} {--rollback=false} {--rewrite=false} {--config=generator} {--except=none} {--fields=none}';

    protected $ucName;

    protected $lcName;

    protected $config;

    protected $file;

    protected $isRewrite;

    protected $isRollback;

    protected $fields;

    public function __construct(Filesystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    public function handle()
    {
        $expArr       = [];
        $appName      = $this->option('name');
        $config       = $this->option('config');
        $except       = $this->option('except');
        $fields       = $this->option('fields');
        $this->fields = 'none' === $fields ? [] : $this->parseFields($fields);
        if (0 !== strcmp($except, 'none')) {
            $expArr = explode(',', $except);
        }

        $this->isRollback = 0 === strcmp($this->option('rollback'), 'false') ? false : true;
        $this->isRewrite  = 0 === strcmp($this->option('rewrite'), 'false') ? false : true;
        $this->config     = config($config);
        $this->ucName     = ucfirst($appName);
        $this->lcName     = lcfirst($appName);
        foreach (static::CREATE_METHOD as $item) {
            $tmp = strtolower(str_replace('create', '', $item));
            if (!method_exists($this, $item)) {
                break;
            }

            if (!empty($expArr)) {
                if (!in_array($tmp, $expArr)) {
                    $this->{$item}();
                }

                continue;
            }

            $this->{$item}();
        }
    }

    protected function createMessage()
    {
        if ($this->isRollback) {
            return;
        }

        $basePath = resource_path('lang/' . config('app.locale') . '/message.php');
        if (!$this->file->exists($basePath)) {
            return;
        }

        $fieldKey = $snake = '';
        if (!empty($this->fields) && is_array($this->fields)) {
            $snake    = Str::snake($this->ucName);
            $fieldKey = "'{$snake}' => [" . PHP_EOL;
            $tab      = "\t\t";
            foreach ($this->fields as $key => $item) {
                if (empty($item)) {
                    continue;
                }

                $fieldKey .= "{$tab}'{$key}' => '{$item}', " . PHP_EOL;
            }

            $fieldKey .= "\t]," . PHP_EOL . "\t" . static::BINDING_FLG;
        }

        $content = $this->file->get($basePath);
        if ('' !== $snake && false === strrpos($content, $snake)) {
            $content = str_replace(static::BINDING_FLG, $fieldKey, $content);
            $this->file->put($basePath, $content);
        }

        $this->info('Message create success');
    }

    protected function createTable()
    {
        $arr           = explode('_', Str::snake($this->ucName));
        $lastNo        = count($arr) - 1;
        $last          = Str::plural($arr[$lastNo]);
        $arr[$lastNo]  = $last;
        $tableName     = trim(implode('_', $arr), '_');
        $fullTableName = sprintf(static::DB_TABLE_NAME, $tableName);
        $allFiles      = $this->file->files(database_path('migrations'));
        if (!empty($allFiles)) {
            foreach ($allFiles as $item) {
                if (false !== strrpos($item->getFilename(), $fullTableName)) {
                    if ($this->isRollback) {
                        $this->file->delete($item->getPathname());
                        $this->info('Repository destroy success');
                        return;
                    }

                    if (!$this->isRewrite) {
                        $this->error('Database table create fail');
                        return;
                    }

                    $this->file->delete($item->getPathname());
                }
            }
        }

        if (!$this->isRollback) {
            $tableCmd = 'cmd mgt ' . $tableName;
            Artisan::call($tableCmd);
            $this->info('Database table create success');
        }
    }

    protected function createRepository()
    {
        ['repository' => $repoConfig] = $this->config;
        [
            'contract' => $contractFile,
            'eloquent' => $eloquentFile,
            'provider' => $providerFile
        ] = $repoConfig['file'];
        $contractPath = $this->getFileBasePath($repoConfig['contract']) . '/' . sprintf($contractFile, $this->ucName);
        $eloquentPath = $this->getFileBasePath($repoConfig['eloquent']) . '/' . sprintf($eloquentFile, $this->ucName);
        $providerPath = $this->getFileBasePath($repoConfig['provider']) . '/' . $providerFile;
        if ($this->file->exists($contractPath) || $this->file->exists($eloquentPath)) {
            if ($this->isRollback) {
                $this->file->delete($contractPath);
                $this->file->delete($eloquentPath);
                if (file_exists($providerPath)) {
                    $fileLines = [];
                    $handle    = fopen($providerPath, "r");
                    while (!feof($handle)) {
                        $line = fgets($handle);
                        if (
                            false !== strpos($line, str_replace('.php', '::class', sprintf($contractFile, $this->ucName)))
                            && false !== strpos($line, str_replace('.php', '::class', sprintf($eloquentFile, $this->ucName)))
                        ) {
                            continue;
                        }

                        $fileLines[] = $line;
                    }

                    fclose($handle);
                    if (!empty($fileLines)) {
                        $content = implode('', $fileLines);
                        $this->file->put($providerPath, $content, true);
                    }
                }

                return;
            }

            if (!$this->isRewrite) {
                $this->error('Repository create fail');
                return;
            }

            $this->file->delete($contractPath);
            $this->file->delete($eloquentPath);
        }

        if (!$this->isRollback) {
            $repoCmd = 'cmd repo ' . $this->ucName;
            Artisan::call($repoCmd);
            $this->info('Repository create success');
        }
    }

    protected function createModel()
    {
        $fieldKey = '';
        if (!empty($this->fields) && is_array($this->fields)) {
            $keys = array_keys($this->fields);
            foreach ($keys as $item) {
                $fieldKey .= "'{$item}', ";
            }
        }

        $modelFileName = $this->ucName . '.php';
        $arr           = [
            $this->ucName => ['{{name}}', '{{ name }}'],
            $fieldKey     => ['{{fields}}', '{{ fields }}']
        ];
        $this->create('model', $modelFileName, $arr);
    }

    protected function createService()
    {
        $serviceFileName = $this->ucName . 'Service.php';
        $arr             = [
            $this->ucName => ['{{name}}', '{{ name }}'],
            $this->lcName => ['{{repo_attr}}', '{{ repo_attr }}']
        ];
        $this->create('service', $serviceFileName, $arr);
    }

    protected function createRequest()
    {
        $snake    = Str::snake($this->ucName);
        $fieldKey = $fieldAttrKey = '';
        if (!empty($this->fields) && is_array($this->fields)) {
            $keys = array_keys($this->fields);
            foreach ($keys as $key => $item) {
                $tab          = "\t\t\t";
                $fieldKey     .= "{$tab}'{$item}' => '', " . PHP_EOL;
                $fieldAttrKey .= "{$tab}'{$item}' => __('message.{$snake}.{$item}'), " . PHP_EOL;
            }
        }

        $fieldKey     = rtrim($fieldKey, PHP_EOL);
        $fieldAttrKey = rtrim($fieldAttrKey, PHP_EOL);
        $arr          = [
            $this->ucName => ['{{name}}', '{{ name }}'],
            $snake        => ['{{id_name}}', '{{ id_name }}'],
            $fieldKey     => ['{{fields}}', '{{ fields }}'],
            $fieldAttrKey => ['{{fields_attr}}', '{{ fields_attr }}'],
        ];
        $this->create('request', '', $arr, true);
    }

    protected function createResponder()
    {
        $snake = Str::snake($this->ucName);
        $fieldKey = $fieldShowKey = $fieldKeyNoPageKey = '';
        if (!empty($this->fields) && is_array($this->fields)) {
            $keys = array_keys($this->fields);
            array_unshift($keys, 'id');
            foreach ($keys as $key => $item) {
                $tab               = "\t\t\t\t";
                $fieldKey          .= "{$tab}'{$item}' => \$model->{$item}, " . PHP_EOL;
                $fieldKeyNoPageKey .= "{$tab}'{$item}' => \$item->{$item}, " . PHP_EOL;
                $tab               = "\t\t\t";
                $fieldShowKey      .= "{$tab}'{$item}' => \$this->result->{$item}, " . PHP_EOL;
            }
        }

        $fieldKey          = rtrim($fieldKey, PHP_EOL);
        $fieldShowKey      = rtrim($fieldShowKey, PHP_EOL);
        $fieldKeyNoPageKey = rtrim($fieldKeyNoPageKey, PHP_EOL);
        $arr               = [
            $this->ucName      => ['{{name}}', '{{ name }}'],
            $snake             => ['{{id_name}}', '{{ id_name }}'],
            $fieldKey          => ['{{fields}}', '{{ fields }}'],
            $fieldShowKey      => ['{{fields_show}}', '{{ fields_show }}'],
            $fieldKeyNoPageKey => ['{{fields_no_page}}', '{{ fields_no_page }}']
        ];

        $this->create('responder', '', $arr, true);
    }

    protected function createController()
    {
        $controllerFileName = $this->ucName . 'Controller.php';
        $arr                = [
            $this->ucName => ['{{name}}', '{{ name }}'],
            $this->lcName => ['{{service_attr}}', '{{ service_attr }}']
        ];
        $this->create('controller', $controllerFileName, $arr);
    }

    protected function create($flag, $fileName, $replaceArr, $hasSuffix = false)
    {
        $module = ucfirst($flag);
        if (!$this->createFile($flag, $fileName, $replaceArr, $hasSuffix)) {
            $this->error($module . ' create fail');
            return;
        }

        $status = $this->isRollback ? 'destroy' : 'create';
        $this->info($module . ' ' . $status . ' success');
    }

    protected function getFileBasePath($namespace)
    {
        $res      = Str::after($namespace, 'App\\');
        $filePath = str_replace('\\', '/', $res);
        return rtrim(app_path($filePath), '/');
    }

    protected function createFile($flag, $fileName, $replaceArr, $hasSuffix)
    {
        $realName = $fileName;
        [
            'namespace' => $namespaces,
            'temp_path' => $tempPath,
        ] = $this->config;
        $tempPathList = $tempPath[$flag];
        if (!is_array($tempPath[$flag])) {
            $tempPathList = [$tempPath[$flag]];
        }

        foreach ($tempPathList as $item) {
            $temp = rtrim($tempPath['base'], '/') . '/' . $item;
            if (!$this->file->exists($temp)) {
                return false;
            }

            $filePath = $this->getFileBasePath($namespaces[$flag]);
            if (empty($fileName)) {
                $tmpFileName = basename($temp, static::TEMP_SUFFIX);
                $realName    = $this->ucName . '/' . ucfirst(Str::camel($tmpFileName)) . '.php';
            }

            $filePath = $filePath . '/' . $realName;
            if ($this->isRollback) {
                $this->file->delete($filePath);
                $dir = dirname($filePath);
                if (Str::endsWith($dir, $this->ucName) && is_dir($dir) && empty($this->file->files($dir))) {
                    rmdir($dir);
                    break;
                }

                continue;
            }

            if ($this->file->exists($filePath)) {
                if (!$this->isRewrite) {
                    return false;
                }

                $this->file->delete($filePath);
            }

            if (!$this->isRollback) {
                $content   = $this->file->get($temp);
                $namespace = $hasSuffix ? $namespaces[$flag] . '\\' . $this->ucName : $namespaces[$flag];
                $content   = str_replace(['{{namespace}}', '{{ namespace }}'], $namespace, $content);
                foreach ($replaceArr as $key => $value) {
                    $content = str_replace($value, $key, $content);
                }

                $dir = dirname($filePath);
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $this->file->put($filePath, $content);
            }
        }

        return true;
    }

    protected function parseFields($fields)
    {
        $result = [];
        $fields = explode(',', $fields);
        foreach ($fields as $item) {
            $tmp             = explode(':', trim($item, ','));
            $result[$tmp[0]] = $tmp[1] ?? '';
        }

        return $result;
    }
}
