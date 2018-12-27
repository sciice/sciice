<?php

namespace Sciice\Http\Controller;

use Sciice\Foundation\ServiceController;
use Sciice\Http\Request\SciiceRequest;
use Sciice\Http\Service\SciiceService;

class SciiceController extends Controller
{
    use ServiceController;

    /**
     * @var \Sciice\Contract\Service|SciiceService
     */
    private $service;

    /**
     * SciiceController constructor.
     *
     * @param \Sciice\Contract\Service|SciiceService $service
     */
    public function __construct(SciiceService $service)
    {
        $this->service = $service;
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function store(SciiceRequest $request)
    {
        return $this->service()->storeAs($request)->response();
    }

    /**
     * @param SciiceRequest $request
     * @param int           $id
     *
     * @return mixed
     */
    public function update(SciiceRequest $request, int $id)
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
