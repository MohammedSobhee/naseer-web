<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
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

        dd(request()->route('id'));

        return [
            //
            'photo' => 'nullable|image',
            'type' => 'required|in:service_provider',
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . request()->route('id'),
            'country_code' => 'required|between:2,4',
            'email' => 'required|email|unique:users,email,'. request()->route('id'),
            'password' => 'nullable|min:6|confirmed',
            'gender' => 'required|in:male,female',
            'city_id' => 'required|exists:cities,id',
            'is_active' => 'nullable',
            'service_provider_type_id' => 'required|exists:service_provider_types,id',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'idno' => 'required',
            'skill' => 'required',
            'bio' => 'nullable',
            'license_type' => 'required|in:licensed,unlicensed',
            'idno_file' => 'nullable|file',
            'skill_file' => 'nullable|file',
            'licensed_file' => 'nullable|file',

        ];
    }
}
