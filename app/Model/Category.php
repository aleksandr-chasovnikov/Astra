<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string  $title
 * @property string  $avatar
 * @property integer $parent_id
 * @property boolean $hidden
 *
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @property Carbon  $deleted_at
 *
 * @property File[]  $files
 */
class Category extends BaseModel
{
    const TABLE_NAME = 'categories';

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
        'avatar',
        'parent_id',
        'hidden',
    ];

    /**
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'categories_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * @return string
     */
    public function avatar()
    {
        return $this->files->last();
    }

    /**
     * @return Collection | static[]
     */
    public function subCategories()
    {
        return Category::query()    //TODO Сортировку по алфавиту?
            ->where('parent_id', $this->id)
            ->get();
    }
}
