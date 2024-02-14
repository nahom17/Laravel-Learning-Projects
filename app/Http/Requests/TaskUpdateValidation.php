<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateValidation extends FormRequest
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
            'title'=>[
                'required'
            ],
            'description'=>[
                'required'
            ],
            'start_date'=>[
                'required',

            ],
            'end_date'=>[
                'required',
                'after:start_date'
            ],
            'user_id'=>[
                'required'
            ],
            'project_id'=>[
                'required'
            ]



        ];
    }
     public function messages()
    {
        return [

            'title.required' => "Het titel is verplicht",
            'description.required' => " Het beschrijving is verplicht",
            'start_date.required' => "Het start datum is verplicht",
            'end_date.required' => "Het eind datum is verplicht",
            'after:start_date' => " Het kiesen eind datum moet een datum zijn start datum",
            'user_id.required' => "Het kiezen van gebruiker is verplicht ",
            'project_id.required' => "Het kiezen van project is verplicht ",

        ];
    }
}
