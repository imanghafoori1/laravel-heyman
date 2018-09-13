<?php

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Imanghafoori\HeyMan\HeyManServiceProvider', \Barryvdh\Debugbar\ServiceProvider::class];
    }
}
