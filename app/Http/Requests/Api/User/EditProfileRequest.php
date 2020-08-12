<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'avatar' => 'nullable|image',
            'name' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'gender' => 'nullable|in:male,female',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'school_id' => 'nullable|exists:schools,id',
            'grade_id' => 'nullable|exists:grades,id',
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
