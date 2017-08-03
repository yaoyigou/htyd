<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Youhuiq extends Model
{
    protected $table = 'youhuiq';
    protected $primaryKey = 'yhq_id';
    public $timestamps = false;

    public function getUserRankAttribute($value)
    {
        if (empty($value)) {
            $value = [];
        } else {
            $value = explode(',', $value);
        }
        return $value;
    }
}
