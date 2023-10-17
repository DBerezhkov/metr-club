<?php

namespace App\Http\Requests\Supervisor\Employee;

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
                'name' => 'required|string',
                'surname' => 'required|string',
                'login' => 'email:rfc,dns|unique:users,email',
                'telnumber' => 'required|string|regex:/.\d$/i',
                'tglogin' => 'nullable|string',
        ];
    }

    public function messages()
    {
      return [
          'name.required' => 'Укажите имя',
          'surname.required' => 'Укажите фамилию',
          'login.email' => 'Укажите корректный адрес электронной почты',
          'login.unique' => 'Введён недопустимый адрес, пожалуйста, укажите другой',
          'telnumber.required' => 'Укажите номер телефона',
          'telnumber.regex' => 'Укажите номер телефона полностью',
      ];
    }
}
