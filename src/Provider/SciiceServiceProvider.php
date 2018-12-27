<?php

namespace Sciice\Provider;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Sciice\Command\Install;
use Sciice\Foundation\Sciice;
use Sciice\Http\Middleware\Authorize;

class SciiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();

        $this->registerServiceMenu();

        $this->registerProvider();

        foreach (config('sciice.style') as $name => $path) {
            Sciice::registerStyle($name, $path);
        }

        foreach (config('sciice.script') as $name => $path) {
            Sciice::registerScript($name, $path);
        }
    }

    public function register()
    {
        $this->app->singleton('sciice', function () {
            return new Sciice();
        });

        $this->registerMiddleware();

        $this->registerConsole();
    }

    /**
     * 发布资源.
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('sciice.php'),
        ], 'sciice-config');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/sciice'),
        ], 'sciice-lang');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/sciice'),
        ], 'sciice-views');

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'sciice-migrations');
    }

    /**
     * 注册资源.
     */
    private function registerResources()
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'sciice');
            // 添加一个 guard.
            Sciice::mergeConfigFrom(__DIR__.'/../../config/auth.php', 'auth');
        }
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'sciice');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'sciice');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/sciice'));
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->registerRouter();
    }

    /**
     * 注册后台菜单配置.
     */
    private function registerServiceMenu()
    {
        Sciice::registerMenu(require __DIR__.'/../../config/menu.php');
    }

    /**
     * 注册路由.
     */
    private function registerRouter()
    {
        Route::group($this->configurationRouter(), function () {
            $this->loadRoutesFrom(__DIR__.'/../../router/router.php');
        });
    }

    /**
     * 路由配置.
     *
     * @return array
     */
    private function configurationRouter()
    {
        return [
            'namespace'  => 'Sciice\Http\Controller',
            'as'         => 'sciice.',
            'prefix'     => config('sciice.path'),
            'middleware' => config('sciice.middleware'),
        ];
    }

    /**
     * 注册其他服务
     */
    private function registerProvider()
    {
        $this->app->register(ValidationServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
    }

    /**
     * 注册中间件.
     */
    private function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('sciice.auth', Authenticate::class);
        $this->app['router']->aliasMiddleware('authorize', Authorize::class);
    }

    /**
     * 注册命令.
     */
    private function registerConsole()
    {
        $this->commands([
            Install::class,
        ]);
    }
}
