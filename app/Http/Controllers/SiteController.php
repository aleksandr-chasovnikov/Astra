<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Post;
use Illuminate\Http\Request;

class SiteController extends BaseController
{
    /**
     * @return $this
     */
    public function index()
    {
        return view('index')->with([
            'categories' => $this->showCategories(),
        ]);
    }

    /**
     * Показать статьи по категории
     *
     * @param int    $categoryId
     *
     * @return $this
     */
    public function showByCategory($categoryId)
    {
        return view('category')->with([
            'posts' => Post::query()->where('category_id', $categoryId)
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
    public function reSortPosts(Request $request)
    {
        $type = $request->type ? $request->type : 'all';
        $sort = $request->sort ? $request->sort : 'created_at';
        $direction = 'desc';

        $type = ('all' === $type) ? [0, 1] : [$type, $type];

        if ('price_asc' === $sort) {
            $direction = 'asc';
            $sort = 'price';
        }

        $category = null;
        $posts = null;
        if (!empty($request->categoryId)) {
            $categoryId = $request->categoryId;
            $category = Category::query()->find($categoryId);
            $posts = Post::query()->where('category_id', $categoryId)
                ->whereIn('type', $type)
                ->orderBy($sort, $direction)
                ->paginate(self::PAGINATE);
        } else {
            $posts = Post::query()->whereIn('type', $type)
                ->orderBy($sort, $direction)
                ->paginate(self::PAGINATE);
        }

        return view('category')->with([
            'posts' => $posts,
            'subCategory' => $category,
            'categories' => $this->showCategories(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function searchPost(Request $request)
    {
        $idOrEmail = $request->input('id_or_email');

        if (preg_match('/.+@.+\..+/i', $idOrEmail)) {
            return view('category')->with([
                'posts' => Post::query()->where('email', $idOrEmail)
                    ->paginate(self::PAGINATE),
                'categories' => $this->showCategories(),
            ]);
        } else {
            return redirect()->route('postShow', ['id' => $idOrEmail]);
        }
    }

}
