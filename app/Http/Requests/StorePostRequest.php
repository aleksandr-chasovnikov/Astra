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
    const PHONE_MIN_LENGTH = 1;

    const TITLE_PATTERN = '#[^\/|\[|\^|\]|\$|\{|\}|=|<|>]#';
    const PHONE_PATTERN = '#^([0-9-]|\+|\(|\))*$#';
    const EMAIL_PATTERN = '/.+@.+\..+/i';

    const MAX_FILE_SIZE = 500000;

    public $arErrorMessage = [
        'max' => 'Слишком длинный текст.',
        'min' => 'Слишком короткий текст.',
        'required' => 'Поле обязательно для заполнения.',
        'email.regex' => 'Непохоже на email.',
        'patternNo' => 'Недопустимый символ: ',
        'invertPattern' => 'Есть недопустимый символ',
        'phone.required' => 'Необходимо указать телефон.',
        'title.required' => 'Необходимо указать заголовок.',
        'phone.regex' => 'Телефон содержит недопустимые символы.',
    ];

    private $captchaCode;

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
            'title' => [
                'required',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'user_name' => [
                'nullable',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'city' => [
                'nullable',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'site' => [
                'nullable',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'skype' => [
                'nullable',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'email' => [
                'nullable',
                'regex:' . self::EMAIL_PATTERN,
                'max:' . self::TITLE_MAX_LENGTH,
            ],
            'content' => [
                'nullable',
                'regex:' . self::TITLE_PATTERN,
                'max:' . self::CONTENT_MAX_LENGTH,
            ],
            'price' => [
                'nullable',
                'regex:' . self::PHONE_PATTERN,
                'max:' . self::PRICE_MAX_LENGTH,
            ],
            'phone' => [
                'required',
                'regex:' . self::PHONE_PATTERN,
                'max:' . self::PRICE_MAX_LENGTH,
            ],
            'file' => 'nullable|file',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => $this->arErrorMessage['title.required'],
            'phone.required' => $this->arErrorMessage['phone.required'],
            'phone.regex' => $this->arErrorMessage['phone.regex'],
            'email.regex' => $this->arErrorMessage['email.regex'],
            'captcha.required' => 'Проверочный код обязателен',
            'captcha.regex' => 'Неверный проверочный код',
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
        $this->captchaCode = array_search($request->data_captcha, $captchaNumbers);

        // Правило "required"
        if ($request->required && (strlen($inputValue) === 0 || !$inputValue)) {
            return response()->json(
                ['error' => $this->arErrorMessage['required']]
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
                    self::PHONE_PATTERN
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
                    self::TITLE_MAX_LENGTH,
                    self::PHONE_MIN_LENGTH,
                    '#^' . $this->captchaCode . '$#',
                    ['invertPattern' => 'Неверный код.']
                );
                break;
            case in_array($inputKey, ['email']):
                $response = $this->validateStrlenRegexp(
                    $inputValue,
                    self::TITLE_MAX_LENGTH,
                    self::TITLE_MIN_LENGTH,
                    self::EMAIL_PATTERN,
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
     * @param array  $errorMessage
     *
     * @return array
     */
    public function validateStrlenRegexp(
        $inputValue,
        $max = self::TITLE_MAX_LENGTH,
        $min = self::TITLE_MIN_LENGTH,
        $patternNo,
        $errorMessage = []
    )
    {
        $errorMessage = $errorMessage + $this->arErrorMessage;

        if (strlen($inputValue) < $min && strlen($inputValue) !== 0) {
            return ['error' => $errorMessage['min']];
        }
        if (strlen($inputValue) > $max) {
            return ['error' => $errorMessage['max']];
        }
        if (!preg_match($patternNo, $inputValue, $matches)) {
            return ['error' => $errorMessage['invertPattern']];
        }

        return ['success' => 'Проверено.'];
    }
}
