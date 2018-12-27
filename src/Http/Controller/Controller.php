<?php

namespace Sciice\Http\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $message
     * @param int    $code
     * @param array  $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json(string $message, int $code = 200, array $headers = [])
    {
        return response()->json(['message' => $message], $code, $headers);
    }
}
