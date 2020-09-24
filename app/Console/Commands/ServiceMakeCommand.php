<?php


namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class ServiceMakeCommand extends GeneratorCommand
{

    protected $name = 'make:service';

    protected $suffix = 'Service';

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    protected function replaceClass($stub, $name)
    {
        $class   = str_replace($this->getNamespace($name) . '\\', '', $name);
        $base    = str_replace($this->suffix, '', $class);
        $content = str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class, $stub);
        return str_replace(['DummyBaseClass', '{{ base }}', '{{base}}'], $base, $content);
    }
}
