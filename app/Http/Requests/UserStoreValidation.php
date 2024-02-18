<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreValidation extends FormRequest
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
                'string',
            ],
            'email' => [
                'required',
                'string',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [

            'name.required' => 'Het naam is verplicht',
            'email.unique' => 'Het email is al bezet',
            'email.required' => 'Het email is verplicht',
            'password.required' => 'Het wachtwoord is verplicht',
            'password.confirmed' => 'Het wachtwoord bevestiging komt niet overeen',

        ];
    }
}
