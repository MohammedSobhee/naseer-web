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
            'service_ids' => 'nullable',
            'service_ids.*' => 'nullable|exists:services,id',
            'text' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'service_ids' => 'الخدمات',
            'text' => 'نص عقد الاتفاق',
        ];
    }
}
