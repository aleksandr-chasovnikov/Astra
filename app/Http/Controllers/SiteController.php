<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Показать все категории
     * 
     * GET /
     */
	public function index()
	{
        return view('index')->with([
            'categories' => Category::all(),
        ]);
	}

    /**
     * Показать одну статью
     * 
     * GET /post.{id}
     */
    public function show($id)
    {
        $article = Article::select(['id', 'title', 'img', 'text', 'created_at'])
                ->where('id', $id)
                ->first();
                
        //Комментарии, принадлежащие статье
        $comments = Article::find($id)->comments()->get();

        //Список категорий
        $categories = Category::select(['id', 'name_category'])->get();

        return view('post')->with(['post' => $article,
                                    'categories' => $categories,
                                    'comments' => $comments,
                                    ]);
    }

    /**
     * Показать статьи по категории
     * 
     * GET /category.{id}
     */
    public function showByCategory($categoryId)
    {
        //Список категорий
        $categories = Category::select(['id', 'name_category'])->get();

        //Выбранная категория
        $category = Category::all()->where('id', $categoryId);        

        //Список статей
        $articles = Article::select(['id', 'title', 'img', 'description', 'created_at'])
                            ->where('categories_id', $categoryId)
                            ->paginate(self::PAGINATE);


        return view('category')->with([
                'articles' => $articles,
                'category' => $category,
                'categories' => $categories
            ]);
    }

}
