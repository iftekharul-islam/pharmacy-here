<?php

namespace Modules\Notice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoticeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notice' => 'required|min:3',
            'bn_notice' => 'required|min:3',
            'type' => 'required'
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
