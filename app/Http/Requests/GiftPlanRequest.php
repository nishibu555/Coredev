<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftPlanRequest extends FormRequest
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
            'relation' => 'nullable|string|max:250|exists:relations.value',
            'gender' => 'nullable|string|max:20',
            'age' => 'nullable|numeric',
            'occasion' => 'nullable|string|max:250|exists:occasions.value',
            'budget' => 'nullable|numeric',
            'share_budget' => 'nullable',
            'currency' => 'nullable|max:20',
            'is_anonymous' => 'nullable',
            'receiver_first_name' => 'required|string|max:250',
            'receiver_last_name' => 'nullable|string|max:250',
            'receiver_email' => 'required|string|max:250',
            'receiver_phone' => 'nullable'
        ];
    }
}
