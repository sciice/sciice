<?php

namespace Sciice\Contract;

use Illuminate\Http\Request;

interface Service
{
    /**
     * @return mixed
     */
    public function response();

    /**
     * @return mixed
     */
    public function resources();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function resource($id);

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request);

    /**
     * @param Request $request
     * @param         $id
     *
     * @return $this
     */
    public function updateAs(Request $request, $id);

    /**
     * @param $id
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function deleteAs($id);
}
