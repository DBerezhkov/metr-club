<?php

namespace App\Http\Requests\Partner\Credit;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
            'search_field' =>'nullable|string',
            'create_date_range' => 'nullable|string',
            'name_of_banks' => 'nullable|array',
        ];
    }
}
