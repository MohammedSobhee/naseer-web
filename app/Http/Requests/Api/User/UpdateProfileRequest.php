<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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


        if (auth()->user()->type == 'user')
            return [
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'nullable|min:6',
                'old_password' => 'required_with:password|min:6',
                'gender' => 'nullable|in:male,female',
                'phone' => 'nullable|unique:users,phone|digits:9',
                'country_code' => 'nullable',//|exists:countries,country_code
                'city_id' => 'nullable|exists:cities,id',

            ];
        else {
            return [
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'nullable|min:6',
                'old_password' => 'required_with:password|min:6',
                'gender' => 'nullable|in:male,female',
                'phone' => 'nullable|unique:users,phone|digits:9',
                'country_code' => 'nullable',//|exists:countries,country_code
                'city_id' => 'nullable|exists:cities,id',

                'service_provider_type_id' => 'nullable|exists:service_provider_types,id',
                'license_type' => 'nullable|in:licensed,unlicensed',
                'idno' => 'nullable',
                'idno_file' => 'nullable|file',
                'skill' => 'nullable',
                'photo' => 'nullable|image',
                'skill_file' => 'nullable|file',
                'address' => 'nullable',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'licensed' => 'nullable',
                'licensed_file' => 'nullable|file',
            ];
        }
    }
}
