<?php

namespace App\Model;

/**
 * @property integer $id
 * @property string  $word
 * @property boolean $status
 */
class Censor extends BaseModel
{
    const TABLE_NAME = 'censor';

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

}
