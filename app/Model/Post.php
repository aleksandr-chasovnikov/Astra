<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer   $id
 * @property string    $title
 * @property string    $content
 * @property string    $type
 * @property string    $categories_id
 * @property string    $promo_order
 * @property string    $img
 * @property string    $avatar
 * @property string    $price
 * @property string    $user_name
 * @property string    $region
 * @property string    $city
 * @property string    $email
 * @property string    $phone
 * @property string    $site
 * @property string    $skype
 * @property string    $lifetime
 * @property string    $password
 * @property string    $link
 * @property string    $hidden
 * @property string    $meta_desc
 * @property integer   $meta_key
 *
 * @property Category[] $category
 * @property File[]    $files
 */
class Post extends BaseModel
{
    const TABLE_NAME = 'posts';

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
        'title',
        'content',
        'type',
        'categories_id',
        'promo_order',
        'img',
        'avatar',
        'price',
        'user_name',
        'region',
        'city',
        'email',
        'phone',
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
    ];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
