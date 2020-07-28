<?php

namespace App\Http\Requests\Api\Gift;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InitiateGiftPlanRequest extends FormRequest
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
            'gender' => ['required', Rule::in(config('enums.genders'))],
            'age_range' => 'required|exists:age_ranges,value',
            'occasion' => 'required|exists:occasions,value',
            'relation' => 'required|exists:relations,value',
            'occasion_date' => 'nullable|date|date_format:Y-m-d'
        ];
    }
}
