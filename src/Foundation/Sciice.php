<?php

namespace Sciice\Foundation;

use BadMethodCallException;

class Sciice
{
    /**
     * @var array
     */
    public static $script = [];

    /**
     * @var array
     */
    public static $style = [];

    /**
     * @var array
     */
    public static $menu = [];

    /**
     * @var array
     */
    public static $component = [];

    /**
     * 注册脚本资源.
     *
     * @param $name
     * @param $path
     *
     * @return Sciice
     */
    public static function registerScript($name, $path)
    {
        static::$script[$name] = $path;

        return new static();
    }

    /**
     * 注册模块资源.
     *
     * @param $name
     * @param $path
     *
     * @return Sciice
     */
    public static function registerComponent($name, $path)
    {
        static::$component[$name] = $path;

        return new static();
    }

    /**
     * 注册样式资源.
     *
     * @param $name
     * @param $path
     *
     * @return Sciice
     */
    public static function registerStyle($name, $path)
    {
        static::$style[$name] = $path;

        return new static();
    }

    /**
     * 注册菜单数据.
     *
     * @param array $menu
     *
     * @return Sciice
     */
    public static function registerMenu(array $menu)
    {
        static::$menu = array_merge(static::$menu, $menu);

        return new static();
    }

    /**
     * 获取脚本资源.
     *
     * @return array
     */
    public static function script()
    {
        return array_merge(static::$script, ['component' => __DIR__.'/../../dist/index.js']);
    }

    /**
     * 获取样式资源.
     *
     * @return array
     */
    public static function style()
    {
        return array_merge(static::$style, [
            'component' => __DIR__.'/../../dist/index.css',
            'umi'       => __DIR__.'/../../api/dist/umi.css',
        ]);
    }

    /**
     * 获取模块资源.
     *
     * @return array
     */
    public static function component()
    {
        return array_merge(static::$component, ['umi' => __DIR__.'/../../api/dist/umi.js']);
    }

    /**
     * 获取菜单数据.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function menu()
    {
        return collect(static::$menu)->sortBy('sort')->values();
    }

    /**
     * 合并配置项.
     *
     * @param $path
     * @param $key
     */
    public static function mergeConfigFrom($path, $key)
    {
        $config = config($key, []);

        app('config')->set($key, array_merge_recursive(require $path, $config));
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (!property_exists(get_called_class(), $method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        return static::${$method};
    }
}
