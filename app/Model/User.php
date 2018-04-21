<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer $id
 * @property integer $region
 * @property integer $avatar
 * @property integer $role
 * @property string  $name
 * @property string  $email
 * @property string  $password
 * @property integer $rememberToken
 * @property integer $phone
 * @property integer $promo_order
 * @property boolean $banned
 * @property boolean $verified
 * @property string  $email_token
 * @property string  $site
 * @property string  $skype
 *
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 *
 * @property File[]  $files
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    const TABLE_NAME = 'users';

    const ROLE_USER = 1;
    const ROLE_MANAGER = 2;
    const ROLE_ADMIN = 3;
    const ROLE_VIP = 4;

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region',
        'avatar',
        'role',
        'name',
        'email',
        'password',
        'phone',
        'promo_order',
        'banned',
        'verified',
        'email_token',
        'site',
        'skype',
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
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
