<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\AccountLog;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\OnlinePay;
use App\Models\OrderAction;
use App\Models\OrderGoods;
use App\Models\OrderInfo;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use Page;

    public $model;

    public function __construct(OrderInfo $model)
    {
        $this->model = $model;
        $this->middleware(function ($request, $next) {
            $this->user             = auth()->user();
            $this->assign['user']   = $this->user;
            $this->assign['action'] = 'order';
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date     = intval($request->input('date'));
        $order_sn = trim($request->input('order_sn'));
        $query    = $this->model->where('user_id', $this->user->user_id);
        switch ($date) {
            case 0:
                $query = $query->where('add_time', '>=', strtotime('-3 month'));
                break;
            case 1:
                $query = $query->where('add_time', '>=', strtotime(date('Y') . '-01-01'))
                    ->where('add_time', '<', strtotime((date('Y') + 1) . '-01-01'));
                break;
            case 2:
                $query = $query->where('add_time', '<', strtotime(date('Y') . '-01-01'));
                break;
        }
        if (!empty($order_sn)) {
            $query = $query->where('order_sn', 'like', '%' . $order_sn . '%');
        }
        $request->offsetSet('date', $date);
        $request->offsetSet('order_sn', $order_sn);
        $query                  = $this->sort_order($query);
        $result                 = $query->Paginate($this->page_num);
        $result                 = $this->add_params($result, $request->all());
        $this->assign['result'] = $result;
        return view('order.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cart $cart, Goods $goods)
    {
        $now         = time();
        $postscript  = trim($request->input('postscript'), '');//订单备注
        $shipping_id = intval($request->input('shipping_id'));//物流id
        if ($shipping_id == -1) {
            $shipping_name = trim($request->input('ps_wl', ''));
            $wl_dh         = trim($request->input('ps_dh', ''));
            if (empty($shipping_name)) {
                tips('请填写物流名称', 1, ['link1' => route('cart.jiesuan'), 'link1_text' => '返回结算页面']);
            }
        } else {
            $shipping_name = Shipping::where('shipping_id', $shipping_id)->value('shipping_name');
            $wl_dh         = '';
        }
        if ($this->user->shipping_name == '' || $this->user->shipping_id == 0) {
            $this->user->shipping_name = $shipping_name;
            $this->user->shipping_id   = $shipping_id;
            $this->user->save();
        }
        $payment = $request->input('payment', '2');//支付方式
        $dzfp    = intval($request->input('dzfp', 0));
        if ($this->user->dzfp != $dzfp) {
            $this->user->dzfp = $dzfp;
            $this->user->save();
        }
        $rec_ids = Cache::tags($this->user->user_id)->get('cart_list');
        //Cache::tags($this->user->user_id)->forget('cart_list');
        $result = $cart->get_cart_goods($this->user, $rec_ids);
        if (count($result) == 0) {
            tips('没有选中商品', 1, ['link1' => route('cart.index'), 'link1_text' => '前往购物车']);
        }
        if (!$rec_ids) {
            tips('不能重复提交订单', 1, ['link1' => route('cart.index'), 'link1_text' => '前往购物车']);
        }
        $goods_amount = 0;
        foreach ($result as $k => $v) {
            $v->subtotal = $v->goods->real_price * $v->goods_number;
            $v->goods    = $goods->area_xg($v->goods, $this->user);//检查是否区域限购

            $message = $goods->check_cart($v->goods, $this->user);//检查各种限制条件
            if ($message['error'] == 1) {
                tips($v->goods->goods_name . $message['message'], 1);
            }

            if ($v->goods_number > $v->goods->goods_number) {
                tips('库存不足', 1, ['link1' => route('cart.index'), 'link1_text' => '前往购物车']);
            }
            if ($v->goods_number > $v->goods->xg_num && $v->goods->xg_num > 0) {//超出限购数量
                tips('超出限购数量', 1, ['link1' => route('cart.index'), 'link1_text' => '前往购物车']);
            }


            $goods_amount += $v->goods->real_price * $v->goods_number;

        }

        //获取收货地址
        $address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)
            ->select('consignee', 'country', 'province', 'city', 'district', 'address', 'zipcode', 'tel', 'mobile', 'email', 'best_time', 'sign_building')
            ->first();

        if (!$address) {
            tips('请选择收货地址', 1);
        }
        $shipping_fee              = 0;
        $total                     = $goods_amount + $shipping_fee;
        $surplus                   = min([$this->user->user_money, $total]);
        $order_amount              = $total - $surplus;
        $pay_name                  = Payment::where('pay_id', $payment)->value('pay_name');
        $order_sn                  = $this->get_order_sn();//订单编号$
        $order_info                = new OrderInfo;
        $order_info->order_sn      = $order_sn;
        $order_info->user_id       = $this->user->user_id;
        $order_info->msn           = $this->user->msn;
        $order_info->ls_zpgly      = $this->user->ls_zpgly;
        $order_info->consignee     = $address->consignee;
        $order_info->country       = $address->country;
        $order_info->province      = $address->province;
        $order_info->city          = $address->city;
        $order_info->district      = $address->district;
        $order_info->address       = $address->address;
        $order_info->zipcode       = $address->zipcode;
        $order_info->tel           = $address->tel;
        $order_info->mobile        = $address->mobile;
        $order_info->email         = $address->email;
        $order_info->best_time     = $address->best_time;
        $order_info->sign_building = $address->sign_building;
        $order_info->postscript    = $postscript;
        $order_info->shipping_id   = $shipping_id;
        $order_info->shipping_name = $shipping_name;
        $order_info->wl_dh         = $wl_dh;
        $order_info->pay_id        = $payment;
        $order_info->pay_name      = $pay_name;
        $order_info->referer       = '本站';
        $order_info->add_time      = $now;
        $order_info->confirm_time  = $now;
        $order_info->how_oos       = '等待所有商品备齐后再发';
        $order_info->goods_amount  = $goods_amount;
        $order_info->shipping_fee  = $shipping_fee;
        $order_info->surplus       = $surplus;
        $order_info->order_amount  = $order_amount;
        $order_info->jp_points     = 0;
        $order_info->zyzk          = 0;
        $order_info->jnmj          = 0;
        $order_info->pack_fee      = 0;
        $order_info->dzfp          = $this->user->dzfp;
        $order_info->is_mhj        = 0;
        $order_info->is_hmd        = $this->user->is_hmd;
        $order_info->discount      = 0;
        $order_info->is_zy         = 0;
        $order_info->inv_content   = is_null($this->user->question) ? '' : $this->user->question;
        $order_info->inv_payee     = is_null($this->user->zq_ywy) ? '' : $this->user->zq_ywy;
        $order_info->pack_id       = is_null($this->user->sex) ? '' : $this->user->sex;
        $order_info->is_gtkf       = $this->user->is_gtkf;

        $flag = DB::transaction(function () use ($order_info, $request, $rec_ids, $now, $result, $cart) {//数据库事务插入订单

            if ($order_info->order_amount == 0) {
                $order_info->pay_status = 2;
                $order_info->pay_time   = $now;
                if ($order_info->surplus > 0) {
                    $order_info->pay_name = '使用余额支付';
                }
            }
            $order_info->save();
            if ($order_info->order_id == 0) {
                return 1;
            }
            $recId        = array();//购物车商品记录id集合
            $a            = [];
            $insert_goods = [];
            foreach ($result as $v) {
                $recId[]                = $v->rec_id;
                $v->extension_code      = 1;
                $insert_goods[]         = [
                    'order_id'       => $order_info->order_id,
                    'goods_id'       => $v->goods->goods_id,
                    'goods_name'     => $v->goods->goods_name,
                    'goods_sn'       => $v->goods->goods_sn,
                    'goods_number'   => $v->goods_number,
                    'goods_number_f' => $v->goods_number,
                    'market_price'   => $v->goods->market_price,
                    'goods_price'    => $v->goods->real_price,
                    'is_real'        => 1,
                    'parent_id'      => 0,
                    'is_gift'        => 0,
                    'is_cur_p'       => $v->goods->is_cx,
                    'is_jp'          => $v->goods->is_jp,
                    'is_zyyp'        => 0,
                    'xq'             => $v->goods->xq,
                    'zyzk'           => $v->goods->zyzk,
                    'suppliers_id'   => $v->goods->suppliers_id,
                    'ckid'           => $v->goods->ckid,
                    'tsbz'           => $v->goods->tsbz,
                    'goods_attr'     => '',
                    'extension_code' => $v->extension_code,
                ];
                $v->goods->goods_number = $v->goods->goods_number - $v->goods_number;
                $a[]                    = [
                    'goods_id'     => $v->goods->goods_id,
                    'goods_number' => $v->goods->goods_number,
                ];
            }
            $cart->updateBatch('ecs_goods', $a);
            $cart->whereIn('rec_id', $recId)->delete();//删除购物车
            OrderGoods::insert($insert_goods);//插入订单商品
            $online              = new OnlinePay();
            $online->update_time = $now;
            $online->order_sn    = $order_info->order_sn;
            $order_info->onlinePay()->save($online);
            /* 2015-6-15 为在线支付主动查询插入支付记录 */
            if ($order_info->surplus > 0) {//记录余额变动
                $this->log_account_change($this->user->user_id, $order_info->surplus * (-1), '支付订单' . ' ' . $order_info->order_sn, $order_info->order_id);
            }
        });
        if (!is_null($flag)) {
            tips('订单购买失败', 1, ['link1' => route('cart.index'), 'link1_text' => '前往购物车']);
        }
        $online_pay = '';
//        if ($order_amount > 0) {
//            $online_pay = '
//                <form style="text-align:center;" id="pay_form" action="' . route('alipay.index') . '" method="get">
//                <input id="J_payonline" style="left: 250px;" value="立即支付" type="button" onclick="alipay()" searchUrl="' . route('user.order_search', ['id' => $order_info->order_id, 'type' => 0]) . '">
//                <input value="' . $order_info->order_id . '" name="id" type="hidden">
//                <input value="0" name="type" type="hidden">
//                </form>
//                <script>
//                function alipay(){
//                    var mask = $("<div class=mask></div>");
//                    $("body").append(mask);
//                    $.ajax({
//                        url:"' . route('alipay.index', ['id' => $order_info->order_id, 'type' => 0]) . '",
//                        type:"get",
//                        dataType:"json",
//                        success:function(data){
//                            $("body").find(".mask").remove();
//                            if(data.error === 1){
//                                alert(data.msg);
//                            }
//                            else if(data.error === 2){
//                                window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
//                            }
//                            else{
//                                $("body").append(data.msg);
//                                int = setInterval("search_alipay()", 3000)
//                            }
//                        }
//                    })
//                }
//                function search_alipay(){
//                    $.ajax({
//                        url:"' . route('user.order_search', ['id' => $order_info->order_id]) . '",
//                        type:"get",
//                        dataType:"json",
//                        success:function($result){
//                            if($result==0){
//                                 window.location="' . route('user.payOk', ['id' => $order_info->order_id]) . '";
//                            }
//                        }
//                    });
//                }
//                </script>
//                ';
//        }
        $this->assign['page_title'] = '订单完成' . '-';
        $this->assign['info']       = $order_info;
        $this->assign['online_pay'] = $online_pay;
        $this->assign['cartStep']   = "
                <li><img src='" . asset('images/cart_03.png') . "'/></li>
                <li><img src='" . asset('images/confirm2.png') . "'/></li>
                <li><img src='" . asset('images/order22.png') . "'/></li>
                ";
        return view('cart.ok', $this->assign);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = $this->model->where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips('订单不存在', 1);
        }
        $info->load('order_goods');
        $this->assign['info'] = $info;
        return view('order.show', $this->assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplus = floatval($request->input('surplus'));
        $info    = $this->model->where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            tips('订单不存在', 1, ['link1' => route('order.index'), 'link1_text' => '前往我的订单']);
        }
        if ($info->order_status == 2) {
            tips('订单已取消', 1, ['link1' => route('order.index'), 'link1_text' => '前往我的订单']);
        }
        if ($supplus > $this->user->user_money || $this->user->user_money == 0) {
            tips('余额不足', 1, ['link1' => route('order.index'), 'link1_text' => '前往我的订单']);
        }
        $supplus = min([$info->order_amount, $supplus, $this->user->user_money]);
        if ($supplus > 0) {
            $this->log_account_change($this->user->user_id, $supplus, '订单:' . $info->order_sn . '使用余额', $id);
            $info->surplus      = $supplus;
            $info->order_amount = $info->order_amount - $supplus;
            if ($info->order_amount == 0) {
                $info->pay_status = 2;
                $info->pay_time   = time();
            }
            $info->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ddgz(Request $request, OrderAction $orderAction)
    {
        if ($request->ajax()) {
            $order_id = $request->input('order_ids');
            $rows     = $orderAction->where('order_id', $order_id)->orderBy('log_time', 'desc')->get();
            $status   = [];  //订单操作记录
            //llPrint($status);
            if ($rows->isEmpty()) {
                $rs       = $this->model->where('order_id', $order_id)
                    ->select('add_time')
                    ->first();
                $status[] = [
                    'status' => 0,
                    'con'    => '您的订单已提交，等待系统审核。',
                    'times'  => date('Y-m-d H:i:s', $rs['add_time']),
                ];
            } else {
                foreach ($rows as $row) {
                    if ($row->order_status == 1 && $row->pay_status == 0 && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 1,
                            'con'    => '请您尽快完成付款，订单为未付款。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 0) {
                        $status[] = [
                            'status' => 2,
                            'con'    => '您的订单商家正在积极备货中，未发货。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 1) {
                        $status[] = [
                            'status' => 3,
                            'con'    => '您的订单商家已开票。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 2) {
                        $status[] = [
                            'status' => 4,
                            'con'    => '您的订单正在出库中，请您耐心等待。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 3) {
                        $status[] = [
                            'status' => 5,
                            'con'    => '您的订单现已出库。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 4) {
                        $status[] = [
                            'status' => 6,
                            'con'    => '您的订单已发货。',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 1 && ($row->pay_status == 2 || $row->pay_status == 1) && $row->shipping_status == 5) {
                        $status[] = [
                            'status' => 7,
                            'con'    => '<font color="red">您的订单已送达成功！已完成。</font>',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                    if ($row->order_status == 2 && $row->pay_status == 0) {
                        $status[] = [
                            'status' => 8,
                            'con'    => '<font color="red">您的订单已取消。</font>',
                            'times'  => date('Y-m-d H:i:s', $row['log_time']),
                        ];
                    }
                }
            }
            return view('layouts.ddgz')->with(['status' => $status]);
        } else {
            exit;
        }
    }

    private function get_order_sn()
    {
        /*
         * 获取订单号，确保订单号唯一
         */
        $is_order_exist = true; //标识，默认订单号已经存在
        do {
            $order_sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $count    = $this->model->where('order_sn', $order_sn)
                ->where('order_sn', 'like', '' . date('Ymd') . '%')->count();
            if (empty($count)) {
                $is_order_exist = false;
            }
        } while ($is_order_exist);
        return $order_sn;
    }

    private function log_account_change($user_id, $user_money = 0, $change_desc = '', $order_id = 0)
    {
        $info               = new AccountLog();
        $info->user_id      = $user_id;
        $info->user_money   = $user_money;
        $info->frozen_money = 0;
        $info->rank_points  = 0;
        $info->pay_points   = 0;
        $info->change_time  = time();
        $info->change_desc  = $change_desc;
        $info->change_type  = 0;
        $info->money_type   = 0;
        $info->order_id     = $order_id;
        $info->save();
        /* 更新用户信息 */
        $this->user->user_money = $this->user->user_money + $info->user_money;
        $this->user->save();
    }

}
