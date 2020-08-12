<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
//            'gender' => 'required|in:male,female',
            'type' => 'required|in:user,service_provider',
            'phone' => 'required|unique:users,phone|digits:9',
            'country_code' => 'required',//|exists:countries,country_code
        ];
    }
}
