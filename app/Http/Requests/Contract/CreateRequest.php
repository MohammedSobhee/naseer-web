<?php

namespace App\Http\Requests\Contract;

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
            'text' => 'required',
            'service_ids' => 'required',
            'service_ids.*' => 'required|exists:services,id',
        ];
    }

    public function attributes()
    {
        return [
            'service_ids' => 'أنواع الخدمات',
        ];
    }
}
