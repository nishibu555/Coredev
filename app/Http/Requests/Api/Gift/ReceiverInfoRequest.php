<?php

namespace App\Http\Requests\Api\Gift;

use Illuminate\Foundation\Http\FormRequest;

class ReceiverInfoRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'receiver_id' => 'required_without:first_name,phone',
                'first_name' => 'string|required_without:receiver_id',
                'last_name' => 'string|nullable',
                'giftee_name' => 'nullable|max:200',
                'phone' => 'required_without:receiver_id',
                'email' => 'email|nullable',
                'relation_with_giftee' => 'nullable',
            ];
        }

        return [
            'first_name' => 'string|required',
            'last_name' => 'string|nullable',
            'giftee_name' => 'nullable|max:200',
            'phone' => 'required',
            'email' => 'email|nullable',
            'relation_with_giftee' => 'nullable',
        ];
    }
}
