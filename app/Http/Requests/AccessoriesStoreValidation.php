<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessoriesStoreValidation extends FormRequest
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

                'name' => [
                    'required',
                    'string',

                ],
                'image' => [
                    'nullable',
                    'image',

                ],
                'price' => [
                    'required',
                    'numeric',
                    'gte:0',

                ],
                'discount_price' => [
                    'nullable',
                    'numeric',
                    'lte:price',
                    'gte:0',

                ],
                'vat' => [
                    'required',
                    'integer',
                ],
            ];

        return $rules;
    }

    public function messages()
    {
        return [

            'name.required' => 'Het naam is verplicht',
            'image.image' => 'voeg een afbeelding met jpeg,png,jpg,gif,webp extensie',
            'price.required' => ' Het prijs is verplicht',
            'price.gte' => 'het korting prijst moet niet negative (-20 of --20)',

            'price.between' => 'Vul geldig prijs in',
            'discount_price.numeric' => 'Vul geldig korting prijs in  (geen - voor de cijfer)',
            'discount_price.gte' => 'vul geldig korting prijs in (min : 0)',
            'discount_price.lte' => 'het korting prijst moet lager dan orginaal price',
            'vat.required' => ' Het btw is verplicht',
            'vat.integer' => 'Het btw moet integer',

        ];
    }
}
