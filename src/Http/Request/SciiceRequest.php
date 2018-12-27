<?php
namespace Sciice\Http\Request;

use Illuminate\Validation\Rule;
use Sciice\Foundation\Form\Request;
use Sciice\Foundation\Form\ValidatorSometime;

class SciiceRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|string',
            'username' => 'required|min:4|string|unique:sciice',
            'email'    => 'required|email|unique:sciice',
            'mobile'   => 'required|mobile|unique:sciice',
            'role'     => 'required',
            'password' => 'required|min:5',
        ];
    }

    /**
     * @return array
     */
    public function update()
    {
        return [
            'name'     => 'required|string',
            'username' => ['required', 'min:4', 'string', Rule::unique('sciice')->ignore($this->route('user'))],
            'email'    => ['required', 'email', Rule::unique('sciice')->ignore($this->route('user'))],
            'mobile'   => ['required', 'mobile', Rule::unique('sciice')->ignore($this->route('user'))],
            'role'     => 'required',
        ];
    }

    /**
     * @param $validator
     *
     * @return ValidatorSometime
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWithValidator($validator)
    {
        return ValidatorSometime::make($validator)->rule('password', 'required|min:5')->validate();
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'role.required' => '角色组不允许为空',
        ];
    }
}