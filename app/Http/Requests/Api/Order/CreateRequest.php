<?php

namespace App\Http\Requests\Api\Order;

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
//        'request_id', 'service_id', 'sub_service_id', 'prosecutor_defender', 'lawsuit_nature', 'lawsuit_proof', 'criminal_case', 'country_id', 'court_name', 'property_country',

        return [
            //
            'city_id' => 'required|exists:cities,id',
//            'level' => 'required|between:1,3',
            'service_id' => 'nullable|exists:services,id',
            'sub_service_id' => 'required_with:service_id|exists:sub_services,id',

            'contact_prefer' => 'required|in:go_to_service_provider,go_to_user,according_agreement',
            'payment_prefer' => 'required|in:down_payment,without_down_payment',
            'service_date' => 'required|date_format:Y-m-d H:i:s',

            'case_text' => 'nullable',
            'case_file' => 'nullable|file',
            'case_audio' => 'nullable|file',

            'evidences_text' => 'nullable',
            'evidences_file' => 'nullable|file',
            'evidences_audio' => 'nullable|file',

            'preferred_outcomes_text' => 'nullable',
            'preferred_outcomes_file' => 'nullable|file',
            'preferred_outcomes_audio' => 'nullable|file',

            //public_prosecution_and_police
            'accused_status' => 'nullable|in:suspended,unsuspended',
            'accused_gender' => 'nullable|in:male,female,minor',

            //court_and_lawsuits
            'prosecutor_defender' => 'nullable|in:prosecutor,defender',
            'lawsuit_nature' => 'nullable|in:individual,company_institution,government_agency',
            'lawsuit_proof' => 'nullable|in:lawsuit,proof',
            'criminal_case' => 'nullable|in:personal,public_prosecution',
            'country_id' => 'nullable|exists:countries,id',
            'court_name' => 'nullable',
            'property_country' => 'nullable',

//            DraftingRegulationAndContract
            'type_service_provided' => 'required_if:service_id,4|in:written,oral',

            //division_of_inheritances
            'heirs_details' => 'required_if:service_id,7',
            'agreers' => 'required_if:sub_service_id,18',
            'against' => 'required_if:sub_service_id,18',
            'money' => 'nullable',
            'real_estate' => 'nullable',
            'bonds_shares' => 'nullable',
            'companies' => 'nullable',
            'others' => 'nullable',

            //companies_registration_and_trademarkings
            'authorization_type' => 'required_if:sub_service_id,23|in:individual,institution',
            'agents_num' => 'required_if:sub_service_id,23|numeric',
            'clients_num' => 'required_if:sub_service_id,23|numeric',
            'debt_value' => 'required_if:sub_service_id,24|numeric',
            'delivery_method' => 'required_if:sub_service_id,24|in:cash,transfer,check',
            'property_value' => 'required_if:sub_service_id,25|numeric',

            //arbitrations
            'subject' => 'required_if:service_id,9',
            'value' => 'required_if:service_id,9',
            'specialty' => 'required_if:service_id,9|in:lawful,legal,engineering,accounting,real_estate,medical,without_specifying',

//            marriage_officers
            'location' => 'required_if:service_id,10',
            'latitude' => 'required_if:service_id,10',
            'longitude' => 'required_if:service_id,10',
            'request_datetime' => 'required_if:service_id,10|date_format:Y-m-d H:i:s',
            'client_idno' => 'required_if:service_id,10',
            'medical_examination' => 'required_if:service_id,10|file',
            'divorce_certificate' => 'required_if:service_id,10|file',

            //assign_experts
            'request_side' => 'required_if:service_id,12|in:judicial_authority,personal_agency',

            //AnnualLegalContract
            'activity' => 'required_if:service_id,5',
            'contract_period' => 'required_if:service_id,5',
            'lawsuit_argument' => 'required_if:service_id,5|numeric',
            'preparation_interception' => 'required_if:service_id,5|numeric',
            'contract_formation' => 'required_if:service_id,5|numeric',
            'contract_revision' => 'required_if:service_id,5|numeric',
            'legal_consultation' => 'required_if:service_id,5|numeric',
            'issue_procuration' => 'required_if:service_id,5|numeric',

        ];
    }
}
