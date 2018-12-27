<?php

namespace Sciice\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Authorize
{
    /**
     * @var array
     */
    private $abilities = [
        'show' => 'update',
    ];

    /**
     * @param         $request
     * @param Closure $next
     * @param null    $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $method = str_after(Route::currentRouteAction(), '@');
        $name = Route::currentRouteName();

        if (array_get($this->abilities, $method)) {
            $name = str_before($name, $method).array_get($this->abilities, $method);
        }

        if (auth($guard)->user()->can($name)) {
            return $next($request);
        }

        return abort(403, '无权限访问！');
    }
}
