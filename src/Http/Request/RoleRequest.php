<?php

namespace Sciice\Http\Request;

use Illuminate\Validation\Rule;
use Sciice\Foundation\Form\Request;

class RoleRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string', Rule::unique('roles')],
            'title' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        return [
            'name'  => ['required', 'string', Rule::unique('roles')->ignore($this->route('role'))],
            'title' => 'required|string',
        ];
    }
}
