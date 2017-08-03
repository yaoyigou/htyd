<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $table = 'order_info';
    protected $primaryKey = 'order_id';

    /**
     * 消费总额
     */
    public function pay_amount($user)
    {
        $amount = static::where('user_id', $user->user_id)
            ->where('order_status', 1)
            ->where('pay_status', 2)
            ->sum('goods_amount');
        return $amount;
    }

    /**
     * 待付款金额
     */
    public function wait_amount($user)
    {
        return static::where('user_id', $user->user_id)
            ->where('order_status', 1)
            ->where('pay_status', 0)
            ->sum('order_amount');
    }

    /*
     * 待发货数量
     */
    public function pay_order($user)
    {
        return static::where('user_id', $user->user_id)
            ->where('order_status', 1)
            ->where('pay_status', 2)
            ->where('shipping_status', 0)
            ->count();
    }

    /*
     * 待付款数量
     */
    public function wait_order($user)
    {
        return static::where('user_id', $user->user_id)
            ->where('order_status', 1)
            ->where('pay_status', 0)
            ->count();
    }

    /*
     * 最近的订单
     */
    public function near_order($user, $num)
    {
        return static::where('user_id', $user->user_id)->where('add_time', '>', strtotime('-1 month'))
            ->select('order_id', 'add_time', 'order_status', 'pay_status', 'shipping_status', 'order_sn', 'goods_amount', 'fhwl_m')
            ->orderBy('order_id', 'desc')->take($num)->get();
    }
}
