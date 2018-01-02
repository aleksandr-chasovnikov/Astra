<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\File;
use App\Model\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseController extends Controller
{
    /**
     * Количество статей на странице
     */
    const PAGINATE = 7; //TODO Создать AdminProfileController для настройки админ-панели из браузера

    /**
     * Проверяет пользователя на наличие администраторских прав
     *
     * @return true
     *
     * @throws HttpException
     */
    public static function checkAdmin()
    {
        if (Auth::check() && isAdmin()) {
            return true;
        }

        abort(403, 'Доступ запрещён!');
    }

    /**
     * Возращает список категорий
     *
     * @return Category[] | Collection
     */
    protected function showCategories()
    {
        return Category::query()
            ->orderBy('title')
            ->where('hidden', false)
            ->get();
    }

    /**
     * Возращает список статей, разрешенных к показу
     *
     * @param string $tagId
     * @param string $categoryId
     *
     * @return Builder
     */
    protected function allPosts($tagId = null, $categoryId = null)
    {
        $posts = Post::query()
            ->latest()
//            ->where('published_at', '<=', Carbon::now()) //TODO Реализовать постепенную самопубликацию по устанновленным датам
            ->where('status', true);

        if (!empty($categoryId)) {
            $posts = $posts->where('categories_id', $categoryId);
        }

        if (!empty($tagId)) {
            $posts = $posts->whereHas('tags', function(Builder $builder) use ($tagId) {
                $builder->where('tag_id', $tagId);
            });
        }

        return $posts;
    }

    /**
     * Возращает три последние статьи
     *
     * @param Builder $posts
     *
     * @return Post[] | Collection
     */
    protected function recentPosts(Builder $posts)
    {
        return $posts->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }

    /**
     * Возращает три самые популярные статьи
     *
     * @param Builder $posts
     *
     * @return Post[] | Collection
     */
    protected function popularPosts(Builder $posts)
    {
        return $posts->orderBy('viewed', 'desc')
            ->limit(3)
            ->get();
    }

    /**
     * Возращает последний файл к статье
     *
     * @param $id
     *
     * @return File[]
     */
    protected function getFiles($id)
    {
        return Post::query()
            ->find($id)
            ->files
            ->last();
    }
}
