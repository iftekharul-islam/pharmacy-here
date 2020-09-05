<?php

namespace Modules\Resources\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResourceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|string',
            'bn_title' => 'required|min:3|string',
            'description' => 'required|min:3|string',
            'bn_description' => 'required|min:3|string',
            'url' => 'required',
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
