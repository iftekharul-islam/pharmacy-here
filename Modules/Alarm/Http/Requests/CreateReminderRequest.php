<?php

namespace Modules\Alarm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReminderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reminder_id' => 'required',
            'frequency' => 'required',
            'start_date' => 'required',
            'duration_type' => 'required',
            'duration_days' => 'required',
            'days_type' => 'required',
            'medicine_type' => 'required',
            'medicine_strength' => 'required',
            'medicine_name' => 'required',
            'patient_name' => 'required',
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
