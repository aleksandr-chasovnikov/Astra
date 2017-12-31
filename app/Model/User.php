<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property integer   $id
 * @property string    $role
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property integer   $rememberToken
 * @property integer   $email_token
 * @property integer   $verified
 * @property string    $phone
 * @property string    $avatar
 * @property string    $region
 * @property string    $city
 * @property string    $site
 * @property string    $skype
 * @property string    $balance
 * @property string    $promo_order
 * @property string    $banned
 *
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property Carbon   $deleted_at
 *
 * @property File[]    $files
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    const TABLE_NAME = 'users';

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_VIP = 'vip';
    const ROLE_USER = 'user';

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
        'role',
        'name',
        'email',
        'password',
        'email_token',
        'verified',
        'phone',
        'avatar',
        'region',
        'city',
        'skype',
        'balance',
        'promo_order',
        'banned',
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
