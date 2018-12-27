<?php

namespace Sciice\Tests;

use Sciice\Facades\Sciice;
use Sciice\Provider\SciiceServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $authenticatedAs;

    protected function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->withFactories(__DIR__ . '/factories');
        $this->withHeader('X-Requested-With', 'XMLHttpRequest');
    }

    protected function getPackageProviders($app)
    {
        return [
            SciiceServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Sciice' => Sciice::class
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
        $user = factory(\Sciice\Model\Sciice::class)->create();

        $role = Role::create(['name' => 'test', 'title' => 'test', 'guard_name' => 'sciice',]);

        $arrController = ['user', 'role', 'authorize'];
        $arrAction = ['index', 'store', 'update', 'destroy'];
        foreach ($arrController as $item) {
            foreach ($arrAction as $value) {
                Permission::create([
                    'name'       => 'sciice.' . $item . '.' . $value,
                    'title'      => $item . '.' . $value,
                    'guard_name' => 'sciice',
                    'grouping'   => 'sciice'
                ])->assignRole($role);
            }
        }

        $user->assignRole($role);

        $this->actingAs($user, 'sciice');

        return $user;
    }
}
