<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            //
            'name' => 'required',
            'username' => 'required',
            'phone' => 'required|unique:admins,phone,' . request()->route('id'),
            'email' => 'required|email|unique:admins,email,' . request()->route('id'),
            'password' => 'nullable|min:6',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'اسم كامل',
            'username' => 'اسم المستخدم',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الالكتروني',
            'password' => 'كلمة المرور',
        ];
    }
}
