<?php

namespace Sciice\Http\Controller;

use Illuminate\Http\Request;
use Sciice\Foundation\Sciice;

class ResourcesController extends Controller
{
    /**
     * @param Request $request
     * @param         $name
     *
     * @return \Illuminate\Http\Response
     */
    public function script(Request $request, $name)
    {
        return response(
            file_get_contents(Sciice::script()[$name]),
            200, ['Content-Type' => 'application/javascript']
        );
    }

    /**
     * @param Request $request
     * @param         $name
     *
     * @return \Illuminate\Http\Response
     */
    public function component(Request $request, $name)
    {
        return response(
            file_get_contents(Sciice::component()[$name]),
            200, ['Content-Type' => 'application/javascript']
        );
    }

    /**
     * @param Request $request
     * @param         $name
     *
     * @return \Illuminate\Http\Response
     */
    public function style(Request $request, $name)
    {
        return response(
            file_get_contents(Sciice::style()[$name]),
            200, ['Content-Type' => 'text/css']
        );
    }
}
