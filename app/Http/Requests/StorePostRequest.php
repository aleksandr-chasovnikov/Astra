<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StorePostRequest extends FormRequest
{
    const CONTENT_MAX_LENGTH = 2000;
    const LINK_MAX_LENGTH = 180;
    const TITLE_MAX_LENGTH = 120;
    const PRICE_MAX_LENGTH = 20;

    const TITLE_MIN_LENGTH = 3;
    const PHONE_MIN_LENGTH = 5;

    const TITLE_PATTERN = '#\\|\/|\[|\^|\]|\$|\{|\}|=|<|>#';
    const PHONE_PATTERN = '#^([0-9-]|\+|\(|\))*$#';
    const EMAIL_PATTERN = '/.+@.+\..+/i';

    const ERROR_MESSAGE = [
        'max' => 'Слишком длинный текст.',
        'min' => 'Слишком короткий текст.',
        'patternNo' => 'Недопустимый символ: ',
        'invertPattern' => 'Есть недопустимый символ',
    ];

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

    /**
     * @param Request $request
     * @param array   $captchaNumbers
     *
     * @return array
     */
    public function ajaxValidate(Request $request, $captchaNumbers)
    {
        $inputKey = $request->name;
        $inputValue = $request->value;
        $captchaCode = array_search($request->data_captcha, $captchaNumbers);

        // Правило "required"
        if ($request->required && (strlen($inputValue) === 0 || !$inputValue)) {
            return response()->json(
                ['error' => 'Поле обязательно для заполнения!']
                    + $request->all()
            );
        }

        switch (true) {
            case in_array($inputKey, ['title','user_name','city','site','skype',]):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    self::TITLE_MAX_LENGTH,
                    self::TITLE_MIN_LENGTH,
                    self::TITLE_PATTERN
                ) + ['maxlength' => self::TITLE_MAX_LENGTH];
                break;
            case in_array($inputKey, ['phone','price']):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    self::PRICE_MAX_LENGTH,
                    self::PHONE_MIN_LENGTH,
                    self::PHONE_PATTERN,
                    true
                ) + ['maxlength' => self::PRICE_MAX_LENGTH];
                break;
            case in_array($inputKey, ['content']):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    self::CONTENT_MAX_LENGTH,
                    self::TITLE_MIN_LENGTH,
                    self::TITLE_PATTERN
                ) + ['maxlength' => self::CONTENT_MAX_LENGTH];
                break;
            case in_array($inputKey, ['captcha']):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    null,
                    null,
                    '#^' . $captchaCode . '$#',
                    true,
                    ['invertPattern' => 'Неверный код.']
                );
                break;
            case in_array($inputKey, ['email']):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    self::TITLE_MAX_LENGTH,
                    self::TITLE_MIN_LENGTH,
                    self::EMAIL_PATTERN,
                    true,
                    ['invertPattern' => 'Непохоже на email.']
                ) + ['maxlength' => self::TITLE_MAX_LENGTH];
                break;
            default:
                $response = ['success' => 'Техническая ошибка. Обратитесь в техподдержку.'];
        }

        return $response;
    }

    /**
     * @param        $inputValue
     * @param int    $max
     * @param int    $min
     * @param string $patternNo
     * @param bool   $invertPattern
     * @param array  $errorMessage
     *
     * @return array
     */
    public function validateStrlenRegexp(
        $inputValue,
        $max = self::TITLE_MAX_LENGTH,
        $min = self::TITLE_MIN_LENGTH,
        $patternNo,
        $invertPattern = false,
        $errorMessage = []
    )
    {
        $errorMessage = $errorMessage + self::ERROR_MESSAGE;

        if (strlen($inputValue) < $min && strlen($inputValue) !== 0) {
            return ['error' => $errorMessage['min']];
        }
        if (strlen($inputValue) > $max) {
            return ['error' => $errorMessage['max']];
        }
        if ($invertPattern) {
            if (!preg_match($patternNo, $inputValue, $matches)) {
                return ['error' => $errorMessage['invertPattern']];
            }
        } else {
            if (preg_match($patternNo, $inputValue, $matches)) {
                return ['error' => $errorMessage['patternNo'] . implode('', $matches)];
            }
        }

        return ['success' => 'Проверено.'];
    }
}
