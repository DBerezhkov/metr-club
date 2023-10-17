<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product' => 'required|string',
            'city' => 'required|string',
            'cost' => 'required|string',
            'bank' => 'required|string',
            'date_cd' => 'required|date',
            'client_name' => 'required|string',
        ];
    }
}
