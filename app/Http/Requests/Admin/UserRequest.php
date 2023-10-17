<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name_or_email' => 'nullable|string',
            'agreement' => 'nullable|string',
            'create_date_range' =>  'nullable|string',
            'last_visit_range' => 'nullable|string',
            'agent_contract_type_id' => 'nullable|string',
            'is_online' => 'nullable|string',
            'role' => 'nullable|string|exists:roles,id',
            'region' => 'nullable|string',
            'landing' => 'nullable|integer',
            'presets' => 'nullable|string',
            'rating' => 'nullable|integer',
            'supervisor' => 'nullable|integer',
            'subagent' => 'nullable|integer',
            'supervisors_employees' => 'nullable|integer',
            'count_subagents_from' => 'nullable|integer',
            'count_subagents_to' => 'nullable|integer',
            'agent_data' => 'nullable|string',
        ];
    }
}
