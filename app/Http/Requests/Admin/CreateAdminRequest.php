<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
            'phone' => 'required|unique:admins,phone',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
//            'roles.*' => 'required|exists:roles,id',

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
//            'roles.*' => 'الصلاحيات',
        ];
    }
}
