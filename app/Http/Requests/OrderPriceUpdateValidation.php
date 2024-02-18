<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPriceUpdateValidation extends FormRequest
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
            'price' => [
                'nullable',
                'between:0,999.99',
                'gt:discount_price',

            ],
            'discount_price' => [
                'nullable',
                'numeric',
                'between:0,999.99',
                'min:0',
            ],
        ];
    }

    public function messages()
    {
        return [

            'price.gt' => 'korting prijs  moet lager dan normaal prijs excl',
            //'discount_price.lte' => "het korting prijst moet lager dan orginaal price",
            'discount_price.integer' => 'het korting prijst moet lager dan orginaal price',
            'discount_price.between' => 'Vul geldig korting prijs in geen - , --',
            'discount_price.min' => 'Vul geldig Korting prijs in',
        ];
    }
}
