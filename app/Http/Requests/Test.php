<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Comment;

class Test extends FormRequest
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
            'title' => 'required|unique|max:255',
            'body' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Необходимо указать заголовок',
            'body.required'  => 'Необходимо написать статью',
        ];
    }

}