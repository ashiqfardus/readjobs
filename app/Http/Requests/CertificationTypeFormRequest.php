<?php

namespace App\Http\Requests;

class CertificationTypeFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $certification_type_unique = '';
                    if ($id > 0) {
                        $certification_type_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required",
                        "certification_name" => "required|unique:certification_types$certification_type_unique",
                        "is_default" => "required",
                        "certification_type_id" => "required_if:is_default,0",
                        "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Please select language.',
            'certification_name.required' => 'Certification name required.',
            'is_default.required' => 'Is this Certification name default?',
            'certification_type_id.required_if' => 'Please select default/fallback Certification name.',
            'is_active.required' => 'Is this Certification name active?',
        ];
    }

}
