<?php

namespace Sciice\Http\Controller;

use Sciice\Http\Request\RoleRequest;
use Sciice\Http\Service\RoleService;
use Sciice\Foundation\ServiceController;

class RoleController extends Controller
{
    use ServiceController;

    /**
     * @var \Sciice\Contract\Service|RoleService
     */
    private $service;

    /**
     * RoleController constructor.
     *
     * @param \Sciice\Contract\Service|RoleService $service
     */
    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param RoleRequest $request
     *
     * @return mixed
     */
    public function store(RoleRequest $request)
    {
        return $this->service()->storeAs($request)->response();
    }

    /**
     * @param RoleRequest $request
     * @param int         $id
     *
     * @return mixed
     */
    public function update(RoleRequest $request, int $id)
    {
        return $this->service()->updateAs($request, $id)->response();
    }

    /**
     * @return mixed
     */
    protected function service()
    {
        return $this->service;
    }
}
