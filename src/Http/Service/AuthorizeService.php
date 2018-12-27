<?php

namespace Sciice\Http\Service;

use Illuminate\Http\Request;
use Sciice\Contract\Service;
use Sciice\Foundation\ServiceResponse;
use Sciice\Http\Resource\AuthorizeResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthorizeService implements Service
{
    use ServiceResponse;

    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private $authorize;

    /**
     * AuthorizeService constructor.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Permission $authorize
     */
    public function __construct(Permission $authorize)
    {
        $this->authorize = $authorize->getModel();
    }

    /**
     * @return mixed
     */
    public function resources()
    {
        return AuthorizeResource::collection($this->authorize->whereGuardName('sciice')->get());
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function resource($id)
    {
        return new AuthorizeResource($this->authorize->findOrFail($id));
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $role = Role::findOrFail(1);
        $this->authorize->create(array_merge($request->all(), ['guard_name' => 'sciice']))->assignRole($role);

        return $this;
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return $this
     */
    public function updateAs(Request $request, $id)
    {
        $this->authorize->findOrFail($id)->update($request->all());

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     * @throws \Exception
     */
    public function deleteAs($id)
    {
        $query = $this->authorize->findOrFail($id);

        abort_if($this->authorize->whereParent($query->id)->get()->isNotEmpty(), 403, __('请先删除子权限'));

        $query->delete();

        return $this;
    }
}
