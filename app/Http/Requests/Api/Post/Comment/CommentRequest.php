<?php

namespace App\Http\Requests\Api\Post\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'message' => 'nullable|string',
            'parent_comment_id' => 'nullable|exists:comments,id',
            'images*' => 'nullable|image|max:2048',
            'videos*' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
        ];
    }
}
