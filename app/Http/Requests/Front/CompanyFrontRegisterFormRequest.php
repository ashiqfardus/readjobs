<?php

namespace App\Http\Requests\Front;

use Auth;
use App\Http\Requests\Request;

class CompanyFrontRegisterFormRequest extends Request
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
            'name' => 'required|max:150',
            'email' => 'required|unique:companies,email|email|max:100',
            'company_country' =>'required|max:50',
            'company_phone' =>'required|max:50',
            'password' =>
                [
                    'required',
                    'min:6',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                ],
            'terms_of_use' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required'),
            'email.required' => __('Email is required'),
            'company_country.required' => __('Country is required'),
            'company_phone.required' => __('Phone is required'),
            'email.email' => __('The email must be a valid email address'),
            'email.unique' => __('This Email has already been taken'),
            'password.required' => __('Password is required'),
            'password.min' => __('The Password must be at least 6 characters in length.'),
            'password.regex' => __('The Password must contain atleast one upper case, one lower case, one numeric and special character.'),
            'terms_of_use.required' => __('Please accept terms of use'),
            'g-recaptcha-response.required' => __('Please verify that you are not a robot'),
            'g-recaptcha-response.captcha' => __('Captcha error! try again later or contact site admin'),
        ];
    }

}
