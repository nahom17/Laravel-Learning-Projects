<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('isAdmin', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name'=>[
                'required',
                'string'
            ],
            'address'=>[
                'required',
                'string'
            ],
            'zip_code' =>[
                'required',
                'string'
            ],
            'phone_number'=>[
                'required',
                'numeric'
            ],
            'email'=>[
                'required',
                'email:strict',
            ]
        ];
    }
        public function messages()
    {
        return [

            'name.required' => "Het naam is verplicht",
            'address.required' => "Het adres is verplicht",
            'zip_code.required' => "Het postcode is verplicht",
            'phone_number.required' => "Het telefoonnummer is verplicht",
            'phone_number.numeric' => "Vul in geldig telfoonnummer in",
            'email.required' => "Het email is verplicht",
            'email.strict' => "Vul in geldig email in",


        ];
    }
}
