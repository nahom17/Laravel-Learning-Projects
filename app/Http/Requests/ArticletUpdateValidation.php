<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticletUpdateValidation extends FormRequest
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
        $rules =
            [

            'title' => [
                'required',
                'string'

            ],
            'intro' => [
                'required',
                'string',
            ],
            'description' => [
                'max:4000',
                'required',
            ],
            'image' => [
                'nullable',
                'mimes:jpg,png,jpeg|max:5048',

            ],
            'start_date' =>[
                'required'
            ],
            'end_date'=>[
                'required',
                'after:start_date'
            ]
        ];
        return $rules;
    }
    public function messages()
    {
        return [

            'title.required' => "Het titel is verplicht",
            'intro.required' => "Het intro is verplicht",
            'description.required' => " Het beschrijving is verplicht",
            'start_date.required' => "Het start datum is verplicht",
            'end_date.required' => "Het eind datum is verplicht",
            'end_date.after' => " Het eind datum moet een datum zijn start datum"


        ];
    }
}
