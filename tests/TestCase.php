<?php

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Imanghafoori\HeyMan\HeyManServiceProvider'];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        // $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // and other test setup steps you need to perform
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        // $app['config']->set('database.default', 'testbench');
        // $app['config']->set('database.connections.testbench', [ 'driver'   => 'sqlite', 'database' => ':memory:', 'prefix'   => '', ]);
    }
}
