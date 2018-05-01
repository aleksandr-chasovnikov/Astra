<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Post;
use Illuminate\Http\Request;

class SiteController extends BaseController
{
    /**
     * Показать все категории
     *
     * GET /
     */
    public function index()
    {
        return view('index')->with([
            'categories' => $this->showCategories(),
        ]);
    }

//    /**
//     * Показать одну статью
//     *
//     * GET /post.{id}
//     */
//    public function show($id)
//    {
//        $article = Article::select(['id', 'title', 'img', 'text', 'created_at'])
//                ->where('id', $id)
//                ->first();
//
//        //Комментарии, принадлежащие статье
//        $comments = Article::find($id)->comments()->get();
//
//        //Список категорий
//        $categories = Category::select(['id', 'name_category'])->get();
//
//        return view('post')->with(['post' => $article,
//                                    'categories' => $categories,
//                                    'comments' => $comments,
//                                    ]);
//    }

    /**
     * Показать статьи по категории
     *
     * @param int    $categoryId
     * @param string $type
     * @param string $sort
     *
     * @return $this
     */
    public function showByCategory($categoryId, $type = 'all', $sort = 'created_at')
    {
        $direction = 'desc';

        if ('all' === $type) {
            $type = [0, 1];
        } else {
            $type = [$type, $type];
        }

        if ('price_asc' === $sort) {
            $direction = 'asc';
            $sort = 'price';
        }

        return view('category')->with([
            'posts' => Post::query()->where('category_id', $categoryId)
                ->whereIn('type', $type)
                ->orderBy($sort, $direction)
                ->paginate(self::PAGINATE),
            'subCategory' => Category::query()->find($categoryId),
            'categories' => $this->showCategories(),
        ]);
    }

    /**
     * Сортировка
     * @param Request $request
     *
     * @return $this
     */
    public function postShowByCategory(Request $request)
    {
        $type = $request->type ? $request->type : 'all';
        $sort = $request->sort ? $request->sort : 'created_at';
        $categoryId = $request->categoryId;
        $direction = 'desc';

        $type = ('all' === $type) ? [0, 1] : [$type, $type];

        if ('price_asc' === $sort) {
            $direction = 'asc';
            $sort = 'price';
        }

        return view('category')->with([
            'posts' => Post::query()->where('category_id', $categoryId)
                ->whereIn('type', $type)
                ->orderBy($sort, $direction)
                ->paginate(self::PAGINATE),
            'subCategory' => Category::query()->find($categoryId),
            'categories' => $this->showCategories(),
        ]);
    }

}
