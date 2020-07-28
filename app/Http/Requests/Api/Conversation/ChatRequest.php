<?php

namespace App\Http\Requests\Api\Conversation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChatRequest extends FormRequest
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
            'text' => 'required_without:files,images|max:255',
            'files' => 'nullable',
            'files.*' => 'max:10000|mimes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'images' => 'nullable',
            'images.*' => 'image||max:20000|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
