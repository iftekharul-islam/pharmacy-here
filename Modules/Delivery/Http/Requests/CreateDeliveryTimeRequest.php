<?php

namespace Modules\Delivery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_month' => 'required',
            'end_month' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'delivery_method' => 'required'
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
