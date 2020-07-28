<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgreedLegalRequest extends FormRequest
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
            'agreed_legals' => 'array|required',
            'agreed_legals.*.name' => ['required', Rule::exists('legals', 'name')],
            'agreed_legals.*.version' => ['required', Rule::exists('legals', 'version')],
        ];
    }
}
