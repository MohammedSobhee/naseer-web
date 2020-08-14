<?php

namespace App\Http\Requests\Api\Offer;

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
            //`request_id`, `service_provider_id`, `status`, `payment_type`, `payment_value`, `details`
            'request_id' => 'required|exists:requests,id,status,new',
            'payment_type' => 'required|in:down_payment,late_payment',
            'payment_value' => 'required|numeric',
        ];
    }
}
