<?php

namespace App\Http\Requests\Partner\Api;

use Illuminate\Foundation\Http\FormRequest;

class MakeReportRequest extends FormRequest
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
            'mortgage_report' => 'required_without_all:insurance_report',
            'insurance_report' => 'required_without_all:mortgage_report',
        ];
    }
}
