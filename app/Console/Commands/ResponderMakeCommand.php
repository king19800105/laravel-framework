<?php


namespace App\Console\Commands;


use Illuminate\Console\GeneratorCommand;

class ResponderMakeCommand extends GeneratorCommand
{

    protected $name = 'make:res';

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/responder.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\\' . 'Responders';
    }
}
