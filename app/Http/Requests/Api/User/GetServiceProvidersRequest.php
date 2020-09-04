<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class GetServiceProvidersRequest extends FormRequest
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
            'name' => 'nullable',
            'service_id' => 'nullable|exists:services,id',
            'service_provider_type_id' => 'nullable|exists:service_provider_types,id',
            'city_id' => 'nullable|exists:cities,id',
            'rate' => 'nullable|between:0,5',
        ];
    }
}
