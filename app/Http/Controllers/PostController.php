<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\libraries\GenerateText;
use App\Model\File;
use App\Model\Post;
use App\Model\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends BaseController
{
    private $captchaImage;
    private $captchaNumbers;

    public function __construct()
    {
        $this->captchaNumbers = [
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
        $this->captchaImage = array_random($this->captchaNumbers);
    }
    /**
     * @return View | HttpException
     */
    public function index()
    {
        die('post-index');
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
        die('post-show');
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
            'titleMaxLength' => StorePostRequest::TITLE_MAX_LENGTH,
            'contentMaxLength' => StorePostRequest::CONTENT_MAX_LENGTH,
            'priceMaxLength' => StorePostRequest::PRICE_MAX_LENGTH,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxValidate(Request $request)
    {
        return response()->json(
            (new StorePostRequest())->ajaxValidate($request, $this->captchaNumbers)
                + $request->all()
        );
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
//        TODO Доделать (как передавать код)
//        $this->validate($request, [
//            'captcha' => [
//                'required',
//                'max:6',
//                'regex:/^' . $this->captchaNumber . '$/',
//            ],
//        ], [
//            'captcha.required' => 'Проверочный код обязателен',
//            'captcha.regex' => 'Неверный проверочный код',
//        ]);

        $post = Post::query()->create(
            array_except($request->all(), [
                '_token',
                'captcha',
                'MAX_FILE_SIZE',
                'photo',
            ])
        );

        $this->uploadFile($post->id, $request->file('photo'));

        return view('post.create')->with([
            'categories' => $this->showCategories(),
            'regions' => Region::query()->orderBy('name')->get(),
            'captchaImage' => $this->captchaImage,
            'postId' => $post->id,
            'message' => 'Объявление успешно создано.',
        ]);
    }

    /**
     * @var int $id
     *
     * @return View | HttpException
     */
    public function edit($id)
    {
        die('post-edit');

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
     * @param Request $request
     *
     * @return RedirectResponse | HttpException
     */
    public function update(Request $request)
    {
        die('post-update');

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
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function destroy($id)
    {
        die('post-delete');

        Post::find($id)->delete();

        return redirect()->back();
    }

    /**
     * @param UploadedFile[] | UploadedFile $file
     * @param int                           $postId
     *
     * @return void
     */
    protected function uploadFile($postId, $file = null)
    {
        if ($file) {
            if (is_array($file)) {
                foreach ($file as $photo) {
                    if ($photo->getSize() <= StorePostRequest::MAX_FILE_SIZE
                            && is_writable($photo)) {
                        File::query()->create([
                            'target_id' => $postId,
                            'target_type' => File::TARGET_POST,
                            'path' => config('my_config.img_path') . $photo->storeAs('upload', $photo->getClientOriginalName()),
                        ]);
                    }
                }
            } else {
                $originalName = $file->getClientOriginalName();

                File::query()->create([
                    'target_id' => $postId,
                    'target_type' => File::TARGET_POST,
                    'path' => config('my_config.img_path') . $file->storeAs('upload', $originalName),
                ]);
            }
        }
    }


}
