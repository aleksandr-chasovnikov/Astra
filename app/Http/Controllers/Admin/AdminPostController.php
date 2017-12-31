<?php

namespace App\Http\Controllers\Admin;

use App\Model\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminPostController extends BaseController
{
    /**
     * Показывает все статьи в админ панели
     *
     * GET /admin/post/index
     *
     * @return View | HttpException
     */
    public function index()
    {
        self::checkAdmin();

        $posts = Post::withTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.index')->with([
            'posts' => $posts,
            'categories' => $this->showCategories(),
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
        self::checkAdmin();

        return view('admin.post.create')->with([
            'categories' => $this->showCategories(),
            'tags' => $this->showTags(),
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
        self::checkAdmin();

        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::query()->create(
            array_except($request->all(), ['tags_id'])
        );

        foreach ($request->input('tags_id') as $tagId) {
            $post->tags()->save(new postTag([
                'post_id' => $post->id,
                'tag_id' => $tagId,
            ]));
        }

        return view('admin.post.create')->with([
            'categories' => $this->showCategories(),
            'tags' => $this->showTags(),
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

        return view('admin.post.update')->with([
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
     * Удаляет тег статьи
     *
     * DELETE /admin/post/delete/{post_id}/{tag_id}
     *
     * @param $post
     * @param $tag
     *
     * @return RedirectResponse | HttpException
     */
    public function deleteTag($post, $tag)
    {
        self::checkAdmin();

        postTag::where('post_id', $post)
            ->where('tag_id', $tag)
            ->delete();

        return redirect()->back();
    }

    /**
     * Восстанавливает пользователя
     *
     * GET /admin/post/restore/{id}
     *
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function restore($id)
    {
        self::checkAdmin();

        Post::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()->back();
    }

}
