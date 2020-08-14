<?php

namespace App\Http\Requests\Api\Rate;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'request_id' => 'required|exists:requests,id,user_id,' . auth()->user()->id,
            'service_provider_id' => 'required|exists:users,id,type,service_provider',
            'rate' => 'required|between:0,5'
        ];
    }
}
