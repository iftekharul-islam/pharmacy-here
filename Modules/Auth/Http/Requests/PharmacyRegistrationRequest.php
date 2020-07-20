<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|min:11|max:11',
            'name' => 'required|min:3',
            'email' => 'required|email',
            'alternative_phone_number' => 'required|min:11|max:11',
            'dob' => 'required',
            'gender' => 'required',
            'role' => 'required',
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
}
