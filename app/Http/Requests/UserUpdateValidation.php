<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateValidation extends FormRequest
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
        $rules = [
            'name' => [
                'required',
                'string'
            ],
            'email'=>[
                'required',
                'string',

            ]
        ];
         return $rules;
    }

    public function messages()
    {
        return [

            'name.required' => "Het gebruikernaam is verplicht",
            'email.required' => "Het email is verplicht",

        ];
    }
}
