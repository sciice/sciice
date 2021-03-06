<?php

namespace Sciice\Http\Service;

use Sciice\Model\Sciice;
use Illuminate\Http\Request;
use Sciice\Contract\Service;
use Sciice\Foundation\ServiceResponse;
use Sciice\Http\Resource\SciiceResource;

class SciiceService implements Service
{
    use ServiceResponse;

    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private $sciice;

    /**
     * SciiceService constructor.
     *
     * @param \Illuminate\Database\Eloquent\Builder|Sciice $sciice
     */
    public function __construct(Sciice $sciice)
    {
        $this->sciice = $sciice->getModel();
    }

    /**
     * @return mixed
     */
    public function resources()
    {
        return SciiceResource::collection($this->sciice->with('roles')->paginate());
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function resource(int $id)
    {
        return new SciiceResource($this->sciice->with('roles')->findOrFail($id));
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function storeAs(Request $request)
    {
        $this->sciice->create($request->except('role'))
            ->assignRole($request->input('role'));

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
        abort_if($id === 1, 403, __('该账号不允许编辑'));

        $query = $this->sciice->findOrFail($id);

        $query->update($request->except(['username', 'role']));
        $query->syncRoles($request->input('role'));

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this|Service
     * @throws \Exception
     */
    public function deleteAs(int $id)
    {
        abort_if($id === 1, 403, __('该账号不允许删除'));

        $this->sciice->findOrFail($id)->delete();

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function updateUserInfo(Request $request)
    {
        $this->sciice->findOrFail($request->user('sciice')->id)
            ->update($request->except('username'));

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function avatarImageUpload(Request $request)
    {
        $this->sciice->findOrFail($request->user('sciice')->id)
            ->uploadImage($request->file('avatar'), 'avatar');

        return $this;
    }
}
