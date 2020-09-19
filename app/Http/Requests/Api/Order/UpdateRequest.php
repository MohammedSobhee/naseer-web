<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
//            'city_id' => 'nullable|exists:cities,id',
////            'level' => 'required|between:1,3',
//            'service_id' => 'nullable|exists:services,id',
//            'sub_service_id' => 'nullable|exists:sub_services,id',

//            'contact_prefer' => 'nullable|in:go_to_service_provider,go_to_user,according_agreement',
//            'payment_prefer' => 'nullable|in:down_payment,without_down_payment',
//            'service_date' => 'nullable|date_format:Y-m-d H:i:s',

            'case_text' => 'nullable',
//            'case_file' => 'nullable|file',
//            'case_audio' => 'nullable|file',

            'evidences_text' => 'nullable',
//            'evidences_file' => 'nullable|file',
//            'evidences_audio' => 'nullable|file',

            'preferred_outcomes_text' => 'nullable',
//            'preferred_outcomes_file' => 'nullable|file',
//            'preferred_outcomes_audio' => 'nullable|file',

//            //public_prosecution_and_police
//            'accused_status' => 'nullable|in:suspended,unsuspended',
//            'accused_gender' => 'nullable|in:male,female,minor',

//            //court_and_lawsuits
//            'prosecutor_defender' => 'nullable|in:prosecutor,defender',
//            'lawsuit_nature' => 'nullable|in:individual,company_institution,government_agency',
//            'lawsuit_proof' => 'nullable|in:lawsuit,proof',
//            'criminal_case' => 'nullable|in:personal,public_prosecution',
//            'country_id' => 'nullable|exists:countries,id',
//            'court_name' => 'nullable',
//            'property_country' => 'nullable',

////            DraftingRegulationAndContract
//            'type_service_provided' => 'required_if:service_id,4|in:written,oral',

//            //division_of_inheritances
//            'heirs_details' => 'nullable',
//            'agreers' => 'nullable',
//            'against' => 'nullable',
//            'money' => 'nullable',
//            'real_estate' => 'nullable',
//            'bonds_shares' => 'nullable',
//            'companies' => 'nullable',
//            'others' => 'nullable',

//            //companies_registration_and_trademarkings
//            'authorization_type' => 'nullable|in:individual,institution',
//            'agents_num' => 'nullable|numeric',
//            'clients_num' => 'nullable|numeric',
//            'debt_value' => 'nullable|numeric',
//            'delivery_method' => 'nullable|in:cash,transfer,check',
//            'property_value' => 'nullable|numeric',

//            //arbitrations
//            'subject' => 'nullable',
//            'value' => 'nullable',
//            'specialty' => 'nullable|in:lawful,legal,engineering,accounting,real_estate,medical,without_specifying',

////            marriage_officers
//            'location' => 'nullable',
//            'latitude' => 'nullable',
//            'longitude' => 'nullable',
//            'request_datetime' => 'nullable|date_format:Y-m-d H:i:s',
//            'client_idno' => 'nullable',
//            'medical_examination' => 'nullable|file',
//            'divorce_certificate' => 'nullable|file',

//            //assign_experts
//            'request_side' => 'nullable|in:judicial_authority,personal_agency',

//            //AnnualLegalContract
//            'activity' => 'nullable',
//            'contract_period' => 'nullable',
//            'lawsuit_argument' => 'nullable|numeric',
//            'preparation_interception' => 'nullable|numeric',
//            'contract_formation' => 'nullable|numeric',
//            'contract_revision' => 'nullable|numeric',
//            'legal_consultation' => 'nullable|numeric',
//            'issue_procuration' => 'nullable|numeric',

        ];
    }
}
