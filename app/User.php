<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer   $id
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property string    $role
 * @property integer   $rememberTokenName
 * @property integer   $email_token
 * @property integer   $verified
 *
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property Carbon   $deleted_at
 *
 * @property Article[] $articles
 * @property File[]    $files
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    const TABLE_NAME = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
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
