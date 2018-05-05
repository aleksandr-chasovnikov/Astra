<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Model\File;
use App\Model\Post;
use App\Model\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends BaseController
{
    private $captchaCode;
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
//        $r = Post::query()->findOrFail($id);
//        $ed = [];
//        foreach ($r->files as $e) {
//            $ed[] = $e->path;
//        }
//        dd($ed);

        return view('post.show')->with([
            'post' => Post::query()->findOrFail($id),
            'categories' => $this->showCategories(),
        ]);
    }

    /**
     * Выводит форму для создания статьи
     *
     * @return View | HttpException
     */
    public function create()
    {
        $this->captchaCode = array_search($this->captchaImage, $this->captchaNumbers);
        session(['captchaCode' => $this->captchaCode]);

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
        return response()->json((new StorePostRequest())
                ->ajaxValidate($request, $this->captchaNumbers) + $request->all()
        );
    }

    /**
     * @return array
     */
    public function ajaxCaptchaRefresh()
    {
        $this->captchaCode = array_search($this->captchaImage, $this->captchaNumbers);
        session(['captchaCode' => $this->captchaCode]);

        return response()->json([
            'captcha' => $this->captchaImage,
        ]);
    }

    /**
     * Сохраняет статью и выводит форму с сообщением об успешной операции
     *
     * @param StorePostRequest $request
     *
     * @return $this | HttpException
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::query()->create( array_except( $request->all(), [
                '_token',
                'captcha',
                'MAX_FILE_SIZE',
                'files',
            ]));
        $this->uploadFile($post->id, $request->file('files'));

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
     * @param UploadedFile[] | UploadedFile $files
     * @param int                           $postId
     *
     * @return void
     */
    protected function uploadFile($postId, $files = null)
    {
        if ($files) {
            if (is_array($files)) {
                foreach (array_slice(
                    $files,
                    0,
                    StorePostRequest::MAX_FILES_COUNT,
                    true) as $photo) {
                    if (
                        $photo->getSize() <= StorePostRequest::MAX_FILE_SIZE
                            && is_writable($photo)
                    ) {
                        $photo->storeAs('public/app/uploads', $photo->getClientOriginalName());
                        File::query()->create([
                            'target_id' => $postId,
                            'target_type' => File::TARGET_POST,
                            'path' => config('my_config.img_path')
                                . $photo->getClientOriginalName(),
                        ]);
                    }
                }
            } else {
                $originalName = $files->getClientOriginalName();
                $files->storeAs('uploads', $originalName);
                File::query()->create([
                    'target_id' => $postId,
                    'target_type' => File::TARGET_POST,
                    'path' => config('my_config.img_path')
                        . $files->getClientOriginalName(),
                ]);
            }
        }
    }

}
