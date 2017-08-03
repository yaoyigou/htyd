<?php

namespace App\Http\Controllers;

use App\Models\CollectGoods;
use App\Models\Goods;
use App\Models\OrderInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $model;

    public $user;

    public $assign = [];

    public function __construct(User $user)
    {
        Auth::loginUsingId(13960);
        $this->model          = $user;
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    public function index(OrderInfo $orderInfo, CollectGoods $collectGoods, Goods $goods)
    {
        $pay_amount                  = $orderInfo->pay_amount($this->user);// 消费总额
        $wait_amount                 = $orderInfo->wait_amount($this->user);//待付款金额
        $pay_order                   = $orderInfo->pay_order($this->user);//待发货数量
        $wait_order                  = $orderInfo->wait_order($this->user);//待付款数量
        $yyzz_time                   = $this->check_date($this->user->yyzz_time);
        $xkz_time                    = $this->check_date($this->user->xkz_time);
        $zs_time                     = $this->check_date($this->user->zs_time);
        $yljg_time                   = $this->check_date($this->user->yljg_time);
        $near_order                  = $orderInfo->near_order($this->user, 3);//最近的订单
        $collection                  = $collectGoods->collect_near($this->user, 3);//我的收藏
        $this->assign['action']      = '';
        $this->assign['pay_amount']  = $pay_amount;
        $this->assign['wait_amount'] = $wait_amount;
        $this->assign['pay_order']   = $pay_order;
        $this->assign['wait_order']  = $wait_order;
        $this->assign['yyzz_time']   = $yyzz_time;
        $this->assign['xkz_time']    = $xkz_time;
        $this->assign['zs_time']     = $zs_time;
        $this->assign['yljg_time']   = $yljg_time;
        $this->assign['near_order']  = $near_order;
        $this->assign['collection']  = $collection;
        $where                       = function ($query) {
            $query->where('is_wntj', 1);
        };
        $this->assign['wntj']        = $goods->goods_list($this->user, 15, $where);
        return view('user', $this->assign);
    }

    protected function check_date($date)
    {
        if (empty(($date))) {
            return 1;
        }

        $year = substr($date, 0, 4);
        $now  = date('Y');
        if ($year > $now) {
            return 1;
        } else {
            $time = strtotime($date);
            if ($time > $now) {
                return 1;
            }
        }
        return 0;
    }
}
