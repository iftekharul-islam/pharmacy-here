<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePharmacyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pharmacy_name' => 'required|max:191', 
            'pharmacy_address' => 'required|max:191', 
            'bank_account_name' => 'required|max:191', 
            'bank_account_number' => 'required|max:191', 
            'bank_name' => 'required|max:191', 
            'bkash_number' => 'required|max:11|min:11',
            'start_time' => 'required|max:191',
            "end_time" => 'required|max:191',
            "break_start_time" => 'required|max:191',
            "break_end_time" => 'required|max:191',
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
