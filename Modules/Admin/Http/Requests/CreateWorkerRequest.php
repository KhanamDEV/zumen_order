<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkerRequest extends FormRequest
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
            'email' => 'required|email|unique:workers,email',
            'phone_number' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg|max:' . 5 * 1024,
            'password' => 'required|min:8'
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
            'password' => '',
        ];
    }
}
