<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRequest extends FormRequest
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
            'documents.*.user_id' => 'present',
            'documents.*.mime' => 'required|string',
            'documents.*.file_name' => 'required|string',
            'documents.*.advert_id' => 'present',
            'documents.*.data' => 'required|string'
        ];
    }
}
