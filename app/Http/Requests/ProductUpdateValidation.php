<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateValidation extends FormRequest
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
                'string'

            ],
            'description' => [
                'required',
            ],
            'image' => [
                'nullable',
                'mimes:jpg,png,jpeg|max:5048',

            ],
            'price' =>[
                'required',
                'numeric',
                'gt:0'

            ],
            'discount_price'=>[
                'nullable',
                'numeric',
                'lte:price',
                'gte:0'

            ],
            'vat'=>[
                'required',
                'integer'
            ]
        ];
        return $rules;
    }
    public function messages()
    {
        return [

            'name.required' => "Het naam is verplicht",
            'description.required' => " Het beschrijving is verplicht",
            'image.required'=> "Het afbeeldingsbestand is verplicht ",
            'price.required' => " Het prijs is verplicht",
            //'price.integer' => " Het prijs is moet niet negative (-20 of --20) ",
            'price.gt' => "het orginaal prijst moet hoger dan   korting price",
           // 'price.between' => "het prijst moet decimaal geen worden of alpabeten",
            'discount_price.numeric' => "Vul geldig korting prijs in  (geen - voor de cijfer)",
            'discount_price.lte' => "het korting prijst moet lager dan orginaal price",
            'discount_price.gte' => "het korting prijst moet niet negative (-20 of --20)",
            'vat.required' => " Het btw is verplicht",
            'vat.integer' =>"Het btw moet integer"


        ];
    }
}
