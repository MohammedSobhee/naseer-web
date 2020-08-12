<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class CompleteServiceProviderRequest extends FormRequest
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
            'service_provider_type_id' => 'required|exists:service_provider_types,id',
            'idno' => 'required',
            'idno_file' => 'required|file',
            'skill' => 'required',
            'photo' => 'nullable|image',
            'skill_file' => 'required|file',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }
}
