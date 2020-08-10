<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyBusinessRequest extends FormRequest
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
            'pharmacy_address' => 'required|min:3',
            'area_id' => 'required',

//            'nid_image' => 'required|image|max:2000',
//            'trade_license_image' => 'required|image|max:2000',
//            'drug_license_image' => 'required|image|max:2000',
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
