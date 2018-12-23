<?php

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Imanghafoori\HeyMan\HeyManServiceProvider',
            \Imanghafoori\MakeSure\MakeSureServiceProvider::class,
            \Barryvdh\Debugbar\ServiceProvider::class,
        ];
    }
}
