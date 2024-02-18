<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreValidation extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email:strict',
            'zip_code' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric',
            'city' => 'required',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Vul een geldige naam in',
            'address.required' => 'Vul een geldige adres in',
            'zip_code.required' => 'Vul een geldige postcode in',
            'city.required' => 'Vul een geldige stad in',
            'phone_number.required' => 'Vul een geldige telefoonnummer in',
            'phone_number.numeric' => 'Vul een geldige telefoonnummer in',
            'email.required' => 'Vuel een geldige email in',
            'email.email' => 'Vuel een geldige email in',
        ];
    }
}
