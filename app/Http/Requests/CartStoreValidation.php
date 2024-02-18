<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreValidation extends FormRequest
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
        $rules =
            [
                'quantity' => [
                    'required',
                    'integer',
                    'min:1',

                ],
            ];

        return $rules;
    }

    public function messages()
    {
        return [

            'quantity.required' => 'Het aantal is niet lager dan 1',
            'quantity.integer' => 'Ongeldig aantal',
            'quantity.min' => 'Het mimum is niet lager dan 1',

        ];
    }
}
