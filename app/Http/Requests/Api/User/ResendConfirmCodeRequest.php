<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class ResendConfirmCodeRequest extends FormRequest
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
            'phone' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => trans('app.user.user_id'),
            'phone' => trans('app.user.phone'),

        ];
    }
}
