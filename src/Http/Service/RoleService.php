<?php

namespace Sciice\Http\Service;

use Illuminate\Http\Request;
use Sciice\Contract\Service;
use Spatie\Permission\Models\Role;
use Sciice\Foundation\ServiceResponse;
use Sciice\Http\Resource\RoleResource;

class RoleService implements Service
{
    use ServiceResponse;

    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private $role;

    /**
     * RoleService constructor.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role->getModel();
    }

    /**
     * @return mixed
     */
    public function resources()
    {
        return RoleResource::collection($this->role->whereGuardName('sciice')->get());
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function resource(int $id)
    {
        $query = $this->role->findOrFail($id);
        $authorize = $query->permissions()->pluck('id');

        return (new RoleResource($query))
            ->additional(['authorize' => $authorize]);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $this->role->create(array_merge($request->except('authorize'), ['guard_name' => 'sciice']))
            ->syncPermissions($request->input('authorize'));

        return $this;
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return $this
     */
    public function updateAs(Request $request, int $id)
    {
        $query = $this->role->findOrFail($id);
        $query->update($request->except('authorize'));

        if ($id !== 1) {
            $query->syncPermissions($request->input('authorize'));
        }

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     * @throws \Exception
     */
    public function deleteAs(int $id)
    {
        abort_if($id === 1, 403, '该角色组不允许删除');
        $this->role->findOrFail($id)->delete();

        return $this;
    }
}
