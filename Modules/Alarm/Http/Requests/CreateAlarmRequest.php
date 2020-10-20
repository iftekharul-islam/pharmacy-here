<?php

namespace Modules\Alarm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAlarmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alarm_id' => 'required',
            'date' => 'required',
            'reminder_id' => 'required',
            'status' => 'required',
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
