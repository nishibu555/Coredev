<?php

namespace App\Http\Requests\Api;

use App\Models\Gift\GiftPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyTokenRequest extends FormRequest
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

    public function messages()
    {
        return [
            'dob.date_format' => 'The dob does not match the format yyyy-mm-dd.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $giftPlan = GiftPlan::where('claiming_token', $this->token)->first();
        if(!$giftPlan) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Invalid token');
        }

        return [
            'first_name' => 'required|string|max:250',
            'last_name' => 'nullable|string|max:250',
            'email' => 'nullable|email|max:250|unique:users,email, '.$giftPlan->receiver->id,
            'password' => 'required|confirmed|string|min:6|max:250',
            'phone' => 'nullable|unique:users,phone, '.$giftPlan->receiver->id,
            'gender' => [Rule::in(config('enums.genders')), 'nullable'],
            'dob' => 'nullable|date|date_format:Y-m-d'
        ];
    }
}
