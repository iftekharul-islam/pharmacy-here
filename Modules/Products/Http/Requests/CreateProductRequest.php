<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'status' => 'required|boolean',
            'trading_price' => 'required',
            'purchase_price' => 'required',
            'unit' => 'required',
            'is_saleable' => 'required',
            'conversion_factor' => 'required',
            'type' => 'required',
            'form_id' => 'required',
            'category_id' => 'required',
            'generic_id' => 'required',
            'manufacturing_company_id' => 'required',
            'primary_unit_id' => 'required',
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
