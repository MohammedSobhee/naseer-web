<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class VerifyUserRequest extends FormRequest
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
            'user_id'=>'required|integer',
            'code' => 'required|numeric|digits:4',
            'country_code'=>'required|numeric|digits_between:1,3',
            'mobile'=>'required|digits:9|unique:users,mobile,'.\request()->request->get('user_id'),
            'grant_type'=>'required|in:password',
            'password'=>'required'
        ];
    }
}
