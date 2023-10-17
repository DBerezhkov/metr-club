<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandRequest extends FormRequest
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
            'region' => 'nullable|integer',
            'supervisors_demands' => 'nullable|string',
            'employees_demands' => 'nullable|string',
        ];
    }
}
