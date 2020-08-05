<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePharmacyProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pharmacy_name' => 'required|min:3',
            'name' => 'required|min:3',
            'phone_number' => 'required|min:11|max:11|unique:users,phone_number,' . $this->user()->id,
            'alternative_phone_number' => 'required|min:11|max:11',
            'email' => 'required|email|unique:users,email,'. $this->user()->id
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
