<?php

namespace Sciice\Foundation;

trait ServiceController
{
    /**
     * @return mixed
     */
    public function index()
    {
        return $this->service()->resources();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        return $this->service()->resource($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->service()->deleteAs($id)->response();
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    abstract public function store($request);

    /**
     * @param     $request
     * @param     $id
     *
     * @return mixed
     */
    abstract public function update($request, $id);

    /**
     * @return mixed
     */
    abstract protected function service();
}
