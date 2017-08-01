<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';

    public function goods_attr()
    {
        return $this->hasMany(GoodsAttr::class, 'goods_id', 'goods_id');
    }
}
