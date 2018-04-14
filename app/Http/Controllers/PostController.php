<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\Model\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends BaseController
{
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

        $this->captchaNumber = array_random($captchaNumbers);
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
            'captchaNumber' => $this->captchaNumber,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxValidate(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'title' => 'max:1',
//        ]);

//        $inputs = [
//            'title'
//        ];
//
//        if (in_array(array_keys($request->all())[0]), $inputs) {
//
//            foreach ($inputs)
//
//        }

        if ( strlen($request->all()['title']) >= 2 ) {

            return response()->json([
                'error' => 'Слишком длинный текст.'
            ]);
        }

        return response()->json([
                'success' => 'Проверено.'
            ]);
    }

    /**
     * Сохраняет статью и выводит форму с сообщением об успешной операции
     *
     * POST /admin/post/store
     *
     * @param Request $request
     *
     * @return $this | HttpException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'email' => 'nullable|email',
//            'phone' => 'nullable|number',
//            'captcha' => 'required|max:6|pattern:' . $this->captchaNumber,
        ]);

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

}
