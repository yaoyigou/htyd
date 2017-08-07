<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\AccountLog;
use App\Models\CollectGoods;
use App\Models\Goods;
use App\Models\OrderInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use Page;

    public $model;

    public function __construct(User $model)
    {
        Auth::loginUsingId(15988);
        $this->set($model);
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
        return view('user.index', $this->assign);
    }

    public function zncg(Request $request)
    {
        $query  = DB::table('order_goods as og')
            ->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.pay_status', 2)
            ->where('oi.user_id', $this->user->user_id)
            ->groupBy('og.goods_id')->orderBy('og.goods_id', 'desc')
            ->select(DB::raw('count(ecs_og.goods_id) as count'), 'og.goods_id');
        $result = $query->Paginate($this->page_num_check());
        $ids    = $result->pluck('goods_id');
        $goods  = Goods::with('goods_attr', 'member_price')->whereIn('goods_id', $ids)->get();
        $arr    = [];
        foreach ($goods as $v) {
            $v                 = $v->attr($v, $this->user);
            $arr[$v->goods_id] = $v;
        }
        foreach ($result as $v) {
            $v->goods = $arr[$v->goods_id];
        }
        $result                 = $this->add_params($result, $request->all());
        $this->assign['result'] = $result;
        return view('user.zncg', $this->assign);
    }

    public function account_log(AccountLog $accountLog)
    {
        $result                 = $accountLog->where('user_id', $this->user->user_id)
            ->where('user_money', '!=', 0)
            ->orderBy('log_id', 'desc')->Paginate($this->page_num_check());
        $this->assign['result'] = $result;
        return view('user.account_log', $this->assign);
    }

    public function show($id)
    {
        return view('user.show', $this->assign);
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

    public function logout()
    {
        Auth::logout();
    }
}
