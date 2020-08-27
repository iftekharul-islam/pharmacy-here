<?php

namespace Modules\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRrequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required',
            'payment_type' => 'required',
            'delivery_type' => 'required',
            //'status' => 'required',
            'delivery_charge' => 'required',
            'amount' => 'required',
            'delivery_time' => 'required',
            //'pharmacy_id' => 'required',
            'shipping_address_id' => 'required',
            'order_items' => 'required',
            'notes' => 'nullable'
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
