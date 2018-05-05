<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer    $id
 * @property integer    $categories_id
 * @property integer    $file_id
 * @property string     $title
 * @property string     $content
 * @property integer    $type
 * @property boolean    $hidden
 * @property integer    $promo_order
 * @property integer    $price
 * @property string     $user_name
 * @property string     $city
 * @property string     $email
 * @property integer    $phone
 * @property string     $site
 * @property string     $skype
 * @property string     $password
 * @property string     $link
 * @property integer    $viewed
 * @property string     $meta_desc
 * @property string     $meta_key
 *
 *
 * @property Carbon     $end_lifetime
 * @property Carbon     $deleted_at
 *
 * @property Category[] $category_id
 * @property Region[]   $region_id
 * @property File[]     $files
 */
class Post extends BaseModel
{
    const TABLE_NAME = 'posts';

    const TYPE_OFFER = 0;   // Предложение
    const TYPE_DEMAND = 1;  // Спрос

    const TWO_WEEKS = 0;    // 2 недели
    const FOUR_WEEKS = 1;   // 4 недели
    const EIGHT_WEEKS = 2;  // 8 недель

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
        'category_id',
        'region_id',
        'file_id',
        'title',
        'content',
        'type',
        'hidden',
        'promo_order',
        'price',
        'user_name',
        'city',
        'email',
        'phone',
        'site',
        'skype',
        'end_lifetime',
        'password',
        'link',
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
        return $this->hasMany(File::class, 'target_id', 'id')
            ->where('target_type', File::TARGET_POST);
    }

    /**
     * Замещает нецензурные слова
     * @param $value
     *
     * @return mixed
     */
    public function censorReplacesWords($value)
    {
        return preg_replace(
            '/(' . implode(')|(', config('censor')) . ')/ui',
            '..',
            $value
        );
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getContentAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getUserNameAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getCityAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getSiteAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getSkypeAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getLinkAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getMetaDescAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getMetaKeyAttribute($value)
    {
        return $this->censorReplacesWords($value);
    }
}
