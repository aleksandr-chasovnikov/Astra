<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Category extends Model
{
    /**
     * Получить все комментарии пользователя.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'categories_id', 'id');
    }
}
