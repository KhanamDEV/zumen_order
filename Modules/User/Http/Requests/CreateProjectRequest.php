<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'owner' => 'required',
            'type' => 'required',
            'delivery_date' => 'required',
            'postal_code' => 'required|digits:7|numeric'

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
            'name' => '',
            'owner' => '',
            'type' => '',
            'delivery_date' => '',
            'importunate' => '',
            'postal_code' => ''
        ];
    }
}
