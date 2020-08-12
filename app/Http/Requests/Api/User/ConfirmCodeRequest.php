<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmCodeRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'phone' => 'required', // if doesn't exist I update mobile number
            'country_id' => 'sometimes',//|exists:countries,id
            'confirm_code' => 'required|digits:4',
            'password' => 'required|min:6',
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required',
            'device_id' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => trans('app.user.user_id'),
            'confirm_code' => trans('app.user.confirm_code'),
            'password' => trans('app.user.password'),
            'phone' => trans('app.user.phone'),
            'country_id' => trans('app.country_id'),
            'device_type' => trans('app.user.device_type'),
            'device_token' => trans('app.user.device_token'),
            'device_id' => trans('app.user.device_id'),

        ];
    }
}
