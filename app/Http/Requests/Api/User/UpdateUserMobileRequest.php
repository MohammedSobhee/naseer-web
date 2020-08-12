<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserMobileRequest extends FormRequest
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
            'code' => 'required|numeric|digits:4',
            'phone' => 'required|digits:9|unique:users,phone,' . auth()->user()->id,
            'country_code' => 'required|numeric|digits_between:1,3',//|exists:countries,code

        ];
    }
}
