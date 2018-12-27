<?php

namespace Sciice\Http\Controller;

use Sciice\Foundation\ServiceController;
use Sciice\Http\Request\AuthorizeRequest;
use Sciice\Http\Service\AuthorizeService;

class AuthorizeController extends Controller
{
    use ServiceController;

    /**
     * @var \Sciice\Contract\Service|AuthorizeService
     */
    private $service;

    /**
     * AuthorizeController constructor.
     *
     * @param \Sciice\Contract\Service|AuthorizeService $service
     */
    public function __construct(AuthorizeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param AuthorizeRequest $request
     *
     * @return mixed
     */
    public function store(AuthorizeRequest $request)
    {
        return $this->service()->storeAs($request)->response();
    }

    /**
     * @param AuthorizeRequest $request
     * @param int              $id
     *
     * @return mixed
     */
    public function update(AuthorizeRequest $request, int $id)
    {
        return $this->service()->updateAs($request, $id)->response();
    }

    /**
     * @return AuthorizeService
     */
    protected function service()
    {
        return $this->service;
    }
}
