<?php

namespace App\Models;

use App\Common\Common;
use Illuminate\Database\Eloquent\Model;

class CollectGoods extends Model
{
    use Common;

    protected $table = 'collect_goods';
    protected $primaryKey = 'rec_id';

    const UPDATED_AT = 'add_time';
    const CREATED_AT = 'add_time';

    protected $dateFormat = 'U';

    public function goods()
    {
        return $this->hasOne(Goods::class, 'goods_id', 'goods_id');
    }

    /**
     * 我的收藏 最新
     */
    public function collect_near($user, $num)
    {
        $result = self::with([
            'goods' => function ($query) {
                $query->with('goods_attr', 'member_price');
            }
        ])->where('user_id', $user->user_id)->where('goods_id', '>', 0)
            ->orderBy('add_time', 'desc')->take($num)->get();
        foreach ($result as $v) {
            $v->goods = $v->goods->attr($v->goods, $user);
        }
        return $result;
    }
}
