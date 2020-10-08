<?php

namespace Modules\Prescription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrescriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_name' => 'required',
            'prescription_date' => 'required',
            'url' => 'required|mimes:jpg,jpeg,png,bmp,tiff |max:5120',
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
