<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Comment;

class Category extends BaseModel
{
    /**
     * Получить все комментарии пользователя.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'categories_id', 'id');
    }
}
