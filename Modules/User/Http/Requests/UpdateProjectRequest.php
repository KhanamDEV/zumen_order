<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner' => 'required',
            'type' => 'required',
            'delivery_date' => 'required',
            'postal_code_head' => 'nullable|digits:3|numeric',
            'postal_code_end' => 'nullable|digits:4|numeric',
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
            'postal_code_head' => '',
            'postal_code_end' => '',
            ];
    }
}
