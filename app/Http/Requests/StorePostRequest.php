<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Получить правила проверки для применения к запросу.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:170',
            'content' => 'required',
            'email' => 'nullable|email',
            'file' => 'nullable|file',
            'phone' => ['required', 'regex:/^([0-9-]|\+|\(|\))*$/'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Необходимо указать заголовок',
            'phone.required' => 'Необходимо указать телефон',
            'phone.regex' => 'Телефон содержит недопустимые символы',
        ];
    }
}
