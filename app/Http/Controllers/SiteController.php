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
     * @param string $type
     * @param string $sort
     *
     * @return $this
     */
    public function showByCategory($categoryId, $type = 'all', $sort = 'created_at')
    {
        $_REQUEST['type'] = null;
        $_REQUEST['sort'] = null;
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
