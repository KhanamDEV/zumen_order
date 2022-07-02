<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.auth('users')->user()->id,
            'phone_number' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg|max:' . env('MAX_UPLOAD') * 1024,
//            'password' => 'nullable|min:8'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'avatar' => '',
            'email' => '',
            'password' => ''
        ];
    }
}
