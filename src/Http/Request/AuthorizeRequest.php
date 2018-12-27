<?php

namespace Sciice\Http\Request;

use Illuminate\Validation\Rule;
use Sciice\Foundation\Form\Request;

class AuthorizeRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => ['required', 'string', Rule::unique('permissions')],
            'title'    => 'required|string',
            'grouping' => 'required|string',
            'parent'   => 'required',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        return [
            'name'     => ['required', 'string', Rule::unique('permissions')->ignore($this->route('authorize'))],
            'title'    => 'required|string',
            'grouping' => 'required|string',
            'parent'   => 'required',
        ];
    }
}
