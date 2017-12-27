<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends BaseModel
{
    /**
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'categories_id', 'id');
    }
}
