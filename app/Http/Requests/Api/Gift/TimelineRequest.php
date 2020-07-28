<?php

namespace App\Http\Requests\Api\Gift;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimelineRequest extends FormRequest
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
            'occasion' => 'required|exists:occasions,value',
            'relation' => 'required|exists:relations,value',
            'action_user_id' => 'required_without:action_user_name',
            'action_user_name' => 'string|nullable',
            'currency' => 'nullable|max:20',
            'event_date' => 'nullable|date|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'event_date.date_format' => 'The event date does not match the format yyyy-mm-dd.'
        ];
    }
}
