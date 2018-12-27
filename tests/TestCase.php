<?php

namespace Sciice\Tests;

use Mockery;
use Sciice\Facades\Sciice;
use Sciice\Provider\SciiceServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $authenticatedAs;

    protected function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->withFactories(__DIR__.'/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            SciiceServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Sciice' => Sciice::class,
        ];
    }

    protected function resolveApplicationCore($app)
    {
        parent::resolveApplicationCore($app);
        $app->detectEnvironment(function () {
            return 'testing';
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get('config');
        $config->set('app.key', 'base64:yk+bUVuZa1p86Dqjk9OjVK2R1pm6XHxC6xEKFq8utH0=');
        $config->set('database.default', 'testing');
        $config->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getApplicationTimezone($app)
    {
        return 'Asia/Shanghai';
    }

    protected function authenticate()
    {
        $this->actingAs($this->authenticatedAs = Mockery::mock(Authenticatable::class), 'sciice');

        $this->authenticatedAs->shouldReceive('getAuthIdentifier')->andReturn(1);
        $this->authenticatedAs->shouldReceive('getKey')->andReturn(1);

        return $this;
    }
}
