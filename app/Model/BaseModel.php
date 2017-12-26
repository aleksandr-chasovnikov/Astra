<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property Carbon   $deleted_at
 */
abstract class BaseModel extends Model
{
    use SoftDeletes;

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
