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
     * GET /category.{id}
     *
     * @param $categoryId
     *
     * @return $this
     */
    public function showByCategory($categoryId)
    {
        return view('category')->with([
                'posts' => Post::query()->where('category_id', $categoryId)
                    ->paginate(self::PAGINATE),
//                'categoryName' => Category::query()->find($categoryId)->first(['title']),
//                'categories' => $this->showCategories()
            ]);
    }

}
