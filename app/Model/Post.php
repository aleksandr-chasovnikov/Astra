<?php

namespace App\Model;

/**
 * @property integer   $id
 * @property string    $name
 * @property string    $password
 * @property string    $role
 * @property integer   $rememberTokenName
 *
 * @property Article[] $articles
 * @property File[]    $files
 */
class Post extends BaseModel
{
    const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'categories_id',
        'promo_order',
        'img',
        'avatar',
        'price',
        'user_name',
        'city',
        'email',
        'phone',
        'email',
        'site',
        'skype',
        'lifetime',
        'password',
        'link',
        'hidden',
        'meta_desc',
        'meta_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'role',
        'remember_token',
    ];


    /**
     * Получить все статьи пользователя.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    /**
     * Получить все комментарии пользователя.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_email', 'email');
    }
}
