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

        $id = auth()->user()->id;
        if (auth()->user()->type == 'user')
            return [
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email,' . $id . ',id',
                'password' => 'nullable|min:6',
                'old_password' => 'required_with:password|min:6',
                'gender' => 'nullable|in:male,female',
                'phone' => 'nullable|digits:9|unique:users,phone,' . $id . ',id',
                'country_code' => 'nullable',//|exists:countries,country_code
                'city_id' => 'nullable|exists:cities,id',

            ];
        else {

            return [
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users,email,' . $id . ',id',
                'password' => 'nullable|min:6',
                'old_password' => 'required_with:password|min:6',
                'gender' => 'nullable|in:male,female',
                'phone' => 'nullable|digits:9|unique:users,phone,' . $id . ',id',
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
