<?php

namespace App\Model;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $target_id
 * @property string  $target_type
 * @property string  $path
 * @property boolean $status
 *
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property Carbon   $deleted_at
 */
class File extends BaseModel
{
    const TABLE_NAME = 'files';

    const TARGET_POST = 1;
    const TARGET_USER = 1;

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

//    /**
//     * Получить все модели, обладающие target.
//     *
//     * @return MorphTo
//     */
//    public function target()
//    {
//        return $this->morphTo();
//    }
}
