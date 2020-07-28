<?php

namespace App\Http\Requests\Api\Gift;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BudgetPlanRequest extends FormRequest
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
            'budget' => 'numeric|required',
            'share_budget' => 'boolean|nullable',
            'is_anonymous' => 'boolean|nullable',
            'idea_level' => ['nullable', Rule::in(config('enums.gift_idea_levels'))]
        ];
    }
}
