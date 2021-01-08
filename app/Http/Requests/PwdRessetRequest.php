<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

class PwdRessetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return Authenticatable|null
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string'
        ];
    }
}
