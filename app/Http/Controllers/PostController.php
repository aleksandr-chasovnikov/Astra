<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Model\Post;
use App\Model\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends BaseController
{
    private $captchaImage;

    private $captchaNumber;

    public function __construct()
    {
        $captchaNumbers = [
            '707956' => 'sdfjifn43efni',
            '664425' => 'fhgreh3rr454gt',
            '120754' => 'jbe4g34gf21wwq',
            '150173' => 'jkui6yerfwec567u',
            '612619' => 'rtrt5445reu74ree',
            '797212' => 'kuyu565rere3ddgh',
            '931090' => '435eetr454ett4w',
            '334906' => 'erter3454eretet',
            '656226' => 'erhry45ytru5yyedfs',
            '922223' => 'gvbbnrtyn4443gdfg',
            '725365' => 'fukjtyertweeweff3',
        ];
        shuffle($captchaNumbers);

        $this->captchaImage = array_shift($captchaNumbers);
        $this->captchaNumber = array_search($this->captchaImage, $captchaNumbers);
    }

    /**
     * @return Factory | View
     */
    public function searchForm()
    {
        return view('post.search');
    }

    /**
     * Показывает все статьи в админ панели
     *
     * GET /admin/post/index
     *
     * @return View | HttpException
     */
    public function index()
    {
        $posts = Post::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('post.index')->with([
            'posts' => $posts,
            'categories' => $this->showCategories(),
        ]);
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function show($id)
    {
        $post = Post::query()
            ->findOrFail($id);

        return view('post.post')->with([
            'post' => $post,
        ]);
    }

    /**
     * Выводит форму для создания статьи
     *
     * GET /admin/post/create
     *
     * @return View | HttpException
     */
    public function create()
    {

        return view('post.create')->with([
            'categories' => $this->showCategories(),
            'regions' => Region::query()->orderBy('name')->get(),
            'captchaImage' => $this->captchaImage,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxValidate(Request $request)
    {
        $inputKey = $request->name;
        $inputValue = $request->value;

        // Правило "required"
        if ($request->required && (strlen($inputValue) === 0)) {
            $responseJson = ['error' => 'Поле обязательно для заполнения!'];

            return response()->json($responseJson + $request->all());
        }

        switch (true) {
            case in_array($inputKey, [
                'title',
                'price',
                'user_name',
                'city',
                'email',
                'phone',
                'site',
                'skype',
            ]):
                $responseJson = $this->validateStrlenRegexp(
                    $inputValue,
                    170,
                    3,
                    '#\\|\/|\[|\^|\]|\$|\{|\}|=|<|>#'
                );

                if (in_array($inputKey, [
                    'phone',
                ])) {
                    $responseJson = $this->validateStrlenRegexp(
                        $inputValue,
                        25,
                        5,
                        '#^([0-9-]|\+|\(|\))*$#',
                        true
                    );
                }
                break;

            case in_array($inputKey, [
                'content',
            ]):
                $responseJson = $this->validateStrlenRegexp(
                    $inputValue,
                    2000,
                    5,
                    '#\\|\/|\[|\^|\]|\$|\{|\}|=|<|>#'
                );
                break;

            case in_array($inputKey, [
                'captcha',
            ]):
                $responseJson = $this->validateStrlenRegexp(
                    $inputValue,
                    6,
                    6,
                    '#^' . $this->captchaNumber . '#',
                    true,
                    ['invertPattern' => 'Неверный код: ' . $this->captchaNumber]
                );
                break;

            default:
                $responseJson = [
                    'success' => 'Техническая ошибка. Обратитесь в техподдержку.'
                ];
        }

        return response()->json($responseJson + $request->all());
    }

    /**
     * Сохраняет статью и выводит форму с сообщением об успешной операции
     *
     * POST /admin/post/store
     *
     * @param StorePostRequest $request
     *
     * @return $this | HttpException
     */
    public function store(StorePostRequest $request)
    {
        $this->validate($request, [
            'captcha' => [
                'required',
                'max:6',
                'regex:/^' . $this->captchaNumber . '$/',
            ],
        ], [
            'captcha.required' => 'Проверочный код обязателен',
            'captcha.regex' => 'Неверный проверочный код',
        ]);

        dd($request->all());

        Post::query()->create(
            array_except($request->all(), [
                '_token',
                'captcha',
                'MAX_FILE_SIZE',
            ])
        );

        return view('post.post.create')->with([
            'message' => 'Статья успешно создана.',
        ]);
    }

    /**
     * Выводит форму для редактирования статьи
     *
     * GET /admin/post/update.{id}
     *
     * @var int $id
     *
     * @return View | HttpException
     */
    public function edit($id)
    {
        self::checkAdmin();

        $post = Post::withTrashed()
            ->where('id', $id)
            ->first();

        return view('post.post.update')->with([
            'post' => $post,
            'categories' => $this->showCategories(),
            'tags' => $this->showTags(),
        ]);
    }

    /**
     * Редактирует статью
     *
     * POST /admin/post/update
     *
     * @param Request $request
     *
     * @return RedirectResponse | HttpException
     */
    public function update(Request $request)
    {
        self::checkAdmin();

        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        $postId = Post::withTrashed()
            ->where('id', $request->id)
            ->update(array_except($request->all(), ['tags_id', '_token']));

        foreach ($request->input('tags_id') as $tagId) {
            postTag::create([
                'post_id' => $request->id,
                'tag_id' => $tagId,
            ]);
        }

        return redirect()->route('postEdit', ['id' => $postId]);
    }

    /**
     * Удаляет статью
     *
     * DELETE /admin/post/delete/{id}
     *
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function destroy($id)
    {
        self::checkAdmin();

        Post::find($id)->delete();

        return redirect()->back();
    }

    /**
     * @param        $inputValue
     * @param int    $max
     * @param int    $min
     *
     * @param string $patternNo
     * @param bool   $invertPattern
     * @param array  $errorMessage
     *
     * @return array
     */
    protected function validateStrlenRegexp(
        $inputValue,
        $max = 170,
        $min = 3,
        $patternNo,
        $invertPattern = false,
        $errorMessage = []
    )
    {
        $errorMessage = $errorMessage + [
                'max' => 'Слишком длинный текст.',
                'min' => 'Слишком короткий текст.',
                'patternNo' => 'Недопустимый символ: ',
                'invertPattern' => 'Есть недопустимый символ',
            ];


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
