<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer    $id
 * @property string     $title
 * @property string     $content
 * @property string     $type
 * @property integer    $categories_id
 * @property integer    $promo_order
 * @property string     $img
 * @property string     $avatar
 * @property string     $price
 * @property string     $user_name
 * @property string     $region
 * @property string     $city
 * @property string     $email
 * @property integer    $phone
 * @property string     $site
 * @property string     $skype
 * @property string     $password
 * @property string     $link
 * @property boolean    $hidden
 * @property integer    $viewed
 * @property string     $meta_desc
 * @property string     $meta_key
 *
 *
 * @property Carbon     $end_lifetime
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 * @property Carbon     $deleted_at
 *
 * @property Category[] $category
 * @property File[]     $files
 */
class Post extends BaseModel
{
    const TABLE_NAME = 'posts';

    const TYPE_OFFER = 'offer';
    const TYPE_DEMAND = 'demand';

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
        'end_lifetime',
        'password',
        'link',
        'hidden',
        'viewed',
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
