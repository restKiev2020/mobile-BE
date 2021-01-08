<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => \Lang::get('validation.custom.email.unique'),
            'phone_number.unique' => \Lang::get('validation.custom.phone_number.unique')
        ];
    }
}
