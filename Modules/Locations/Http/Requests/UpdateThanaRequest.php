<?php

namespace Modules\Locations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThanaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => "required|string|unique:thanas,name,{$this->id}",
            'name' => "required|string",
            'bn_name' => 'required|string',
            'district_id' => 'required',
            'status' => 'required'
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
