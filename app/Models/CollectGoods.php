<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectGoods extends Model
{
    protected $table = 'collect_goods';
    protected $primaryKey = 'rec_id';

    /**
     * 我的收藏 最新
     */
    public function collect_near($user, $num)
    {
        $ids    = static::where('user_id', $user->user_id)->where('goods_id', '>', 0)
            ->orderBy('add_time', 'desc')->take($num)->pluck('goods_id');
        $result = Goods::with('goods_attr', 'member_price')->whereIn('goods_id', $ids)->get();
        foreach ($result as $v) {
            $v = $v->attr($v,$user);
        }
        return $result;
    }
}
