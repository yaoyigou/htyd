<?php

namespace App\Http\Controllers;

use App\Common\Page;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use Page;

    public $model;

    public function __construct(Cart $model)
    {
        $this->set($model);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Goods $goods)
    {
        //为您推荐
        $cart                        = $this->model->get_cart_goods($this->user);
        $total                       = array();
        $this->order['jp_amount']    = 0;
        $this->order['goods_amount'] = 0;
        $orderstr                    = "";
        $delId                       = [];
        $tip_info                    = [];
        $cache_cart                  = [];//缓存购物车
        $up_num_arr                  = [];
        $up_price_arr                = [];
        $goods_ids                   = [];


        $wkc_goods = [];
        foreach ($cart as $k => $v) {
            $v->is_checked    = 1;
            $v->goods         = $goods->area_xg($v->goods, $this->user);
            $v->is_can_change = 1;
            if ($v->goods->is_can_buy == 0) {
                $v->message = $v->goods->goods_name . "商品限购";
                $delId[]    = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->xg_num == 0 && $v->goods->ls_ggg > 0 && $v->goods->is_xg == 2) {
                //商品有限购 而且商品剩余限购数量为零 而且商品没有在搞特价
                $v->message = $v->goods->goods_name . "商品数量限购";
                $delId[]    = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->real_price == 0) {//如果商品没有库存
                $v->message = $v->goods->goods_name . "价格正在定制中";
                $delId[]    = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);
            } elseif ($v->goods->goods_number == 0) {//如果商品没有库存
                $v->goods_number = 0;
                $v->message      = $v->goods->goods_name . '库存不足';
                //$delId[] = $v->rec_id;
                $v->is_checked    = 0;
                $v->is_can_change = 0;
                $tip_info[]       = $v;
                $wkc_goods[]      = $v;
                unset($cart[$k]);
            } elseif ($v->goods->is_on_sale == 0) {//商品已下架
                $v->message = $v->goods->goods_name . '已下架';
                //$delId[] = $v->rec_id;
                $tip_info[]       = $v;
                $v->is_checked    = 0;
                $v->is_can_change = 0;
                unset($cart[$k]);
                $wkc_goods[] = $v;
            } elseif ($v->goods->is_delete == 1) {//商品已删除
                $v->message = $v->goods->goods_name . '已删除';
                $delId[]    = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            } elseif ($v->goods->is_alone_sale == 0) {//商品不能单独销售
                $v->message = $v->goods->goods_name . '不能单独销售';
                $delId[]    = $v->rec_id;
                $tip_info[] = $v;
                unset($cart[$k]);;
            } else {
                $up_price = [];
                $up_num   = [];
                $zbz      = isset($v->goods->zbz) ? $v->goods->zbz : 1;
                if ($zbz == 0) {
                    $zbz = 1;
                }
                $jzl             = isset($v->goods->jzl) ? intval($v->goods->jzl) : 0;
                $old_num         = $v->goods_number;
                $result          = $this->final_num($v->goods->xg_num, $jzl, $zbz, $v->goods->goods_number, $old_num);
                $v->goods_number = $result['goods_number'];


                $orderstr .= $v->rec_id . '_';
                if ($v->goods->real_price != $v->goods_price) {
                    $up_price['rec_id']      = $v->rec_id;
                    $up_price['goods_price'] = $v->goods->real_price;
                }

                if ($old_num != $v->goods_number && $v->goods_number > 0) {
                    $up_num['rec_id']       = $v->rec_id;
                    $up_num['goods_number'] = $v->goods_number;
                }
                if ($v->goods_number <= 0) {
                    $v->goods_number  = 0;
                    $v->message       = $v->goods->goods_name . '库存不足';
                    $v->is_checked    = 0;
                    $v->is_can_change = 0;
                    $tip_info[]       = $v;
                    unset($cart[$k]);
                    $wkc_goods[] = $v;
                }
                $cache_cart[] = $v->rec_id;

                if (!empty($up_price)) {

                    $up_price_arr[] = $up_price;
                }
                if (!empty($up_num)) {

                    $up_num_arr[] = $up_num;
                }
                if (isset($goods_ids[$v->goods->goods_id])) {
                    $delId[] = $v->rec_id;
                    unset($cart[$k]);;
                } else {
                    $goods_ids[$v->goods->goods_id] = 1;
                    $this->order['goods_amount']    += $v->goods->real_price * $v->goods_number;
                }
            }
        }

        if (count($wkc_goods) > 0) {
            foreach ($wkc_goods as $v) {
                $cart[] = $v;
            }
        }
        if (!empty($delId)) {
            Cart::destroy($delId);
        }
        if (!empty($up_price_arr)) {

            $this->model->updateBatch('ecs_cart', $up_price_arr);
        }
        if (!empty($up_num_arr)) {

            $this->model->updateBatch('ecs_cart', $up_num_arr);
        }
        $total['jp_total_amount']   = sprintf('%.2f', $this->order['jp_amount']);
        $total['shopping_money']    = sprintf('%.2f', $this->order['goods_amount']);
        $this->assign['page_title'] = '购物车-';
        $this->assign['result']     = $cart;
        $this->assign['tip_info']   = $tip_info;
        $this->assign['total']      = $total;
        $this->assign['cartStep']   = "
        <li><img src='" . asset('images/cart_03.png') . "'/></li>
        <li><img src='" . asset('images/cart_04.png') . "'/></li>
        <li><img src='" . asset('images/cart_05.png') . "'/></li>
        ";
        $where                      = function ($query) {
            $query->where('is_wntj', 1);
        };
        $this->assign['wntj']       = $goods->goods_list($this->user, 15, $where);
        Cache::tags($this->user->user_id)->forever('cart_list', $cache_cart);
        return view('cart.index', $this->assign);
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
    public function store(Request $request, Goods $goods)
    {
        $ids = trim($request->input('ids'), ',');
        if (!empty($ids)) {
            $ids = explode(',', $ids);
            $this->plgm($ids, $goods);
            tips('加入购物车成功');
        }
        $id           = intval($request->input('id', 0));
        $goods_number = intval($request->input('num', 0));
        $goods_info   = $goods->with('goods_attr', 'member_price')->where('is_delete', 0)
            ->where('is_alone_sale', 1)
            ->where('is_on_sale', 1)->find($id);
        if ($goods_info) {
            $goods_info = $goods->attr($goods_info, $this->user);
            $goods_info = $goods->area_xg($goods_info, $this->user);
            if ($goods_info['is_can_buy'] == 0) {
                tips('商品限购');
            }
        } else {
            tips('商品已下架', 1);
        }
        $message = $goods->check_cart($goods_info, $this->user);
        if ($message['error'] == 1) {
            tips($message['message'], 1);
        }

        $cart = $this->model->where('goods_id', $id)->where('user_id', $this->user->user_id)->first();
        $type = 0;
        if (!$cart) {
            $cart = new $this->model;
            $type = 1;
        }
        $cart->user_id        = $this->user->user_id;
        $cart->goods_id       = $goods_info->goods_id;
        $cart->goods_sn       = $goods_info->goods_sn;
        $cart->goods_name     = $goods_info->goods_name;
        $cart->goods_price    = $goods_info->real_price;
        $cart->is_real        = $goods_info->is_real;
        $cart->is_gift        = 0;
        $cart->goods_attr     = '';
        $cart->is_shipping    = $goods_info->is_shipping;
        $cart->ls_gg          = $goods_info->ls_gg;
        $cart->ls_bz          = $goods_info->ls_bz;
        $cart->extension_code = time();
        if ($type == 0) {
            $cart->goods_number = $cart->goods_number + $goods_number;
        } else {
            $cart->goods_number = $goods_number;
        }
        if ($cart->goods_number > $goods_info->goods_number) {
            tips('库存不足', 1);
        }
        if ($cart->save()) {
            tips('商品已成功加入购物车');
        }
    }

    protected function plgm($ids, $goods)
    {
        $cart   = $this->model->whereIn('goods_id', $ids)
            ->where('user_id', $this->user->user_id)
            ->pluck('goods_id')->toArray();
        $create = array_diff($ids, $cart);
        $result = $goods->with('goods_attr', 'member_price')->where('is_delete', 0)
            ->where('is_alone_sale', 1)->whereIn('goods_id', $create)
            ->where('is_on_sale', 1)->get();
        if (count($result) > 0) {
            $insert = [];
            $now    = time();
            foreach ($result as $v) {
                $v = $goods->attr($v, $this->user);
                $v = $goods->area_xg($v, $this->user);
                if ($v->is_can_buy == 1) {
                    $message = $goods->check_cart($v, $this->user);
                    if ($message['error'] == 0) {
                        $insert[] = [
                            'user_id'        => $this->user->user_id,
                            'goods_id'       => $v->goods_id,
                            'goods_sn'       => $v->goods_sn,
                            'goods_name'     => $v->goods_name,
                            'goods_price'    => $v->real_price,
                            'is_real'        => $v->is_real,
                            'extension_code' => $now,
                            'is_gift'        => 0,
                            'goods_attr'     => '',
                            'is_shipping'    => $v->is_shipping,
                            'ls_gg'          => $v->ls_gg,
                            'ls_bz'          => $v->ls_bz,
                            'goods_number'   => $v->zbz,
                        ];
                    }
                }
            }
            if (count($insert) > 0) {
                Cart::insert($insert);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $act = trim($request->input('act', ''));
        switch ($act) {
            case 'plsc':
                break;
            default:
                $info = $this->model->where('user_id', $this->user->user_id)->find($id);
                if (!$info) {
                    tips('没有权限这样做', 1);
                }
                $info->delete();
                break;
        }
        tips('删除成功');
    }

    private function final_num($xg_num, $jzl, $zbz, $goods_number, $buy_number, $type = 0)
    {
        $result = [
            'goods_number' => $buy_number,
            'message'      => '',
        ];
        if ($goods_number < $zbz) {
            $goods_number = 0;
        }
        if ($xg_num > 0) {
            $most_num = min([$xg_num, $goods_number]);//取库存和限购余量中较小的
        } else {
            $most_num = $goods_number;
        }
        if ($most_num > 0 && $most_num % $zbz != 0) {//限购数量不是中包装整数倍
            $most_num = floor($most_num / $zbz) * $zbz;
        }
        $buy_number += $zbz * $type;
        $jzl_line   = ceil(($jzl * 0.8) / $zbz) * $zbz;
        if ($jzl > 0 && $jzl % $zbz != 0) {//件装量不是中包装整数倍
            $jzl      = ceil($jzl / $zbz) * $zbz;
            $jzl_line = ceil(($jzl * 0.8) / $zbz) * $zbz;
        }
        if ($jzl > 0) {//件装量存在 且件装量不是购买数量的整数倍
            if ($buy_number % $jzl >= $jzl_line) {//超过件装量80%
                if ($type >= 0) {
                    $buy_number        = ceil($buy_number / $jzl) * $jzl;
                    $result['message'] = '温馨提示：您所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。';
                }
                if ($type < 0) {
                    $buy_number = floor($buy_number / $jzl) * $jzl + ($jzl_line - $zbz);
                }
            }
        }
        $buy_number = min([$buy_number, $most_num]);
        if ($buy_number > 0 && $buy_number % $zbz != 0) {
            $buy_number = ceil($buy_number / $zbz) * $zbz;
        }
        if ($buy_number <= 0) {
            $buy_number = min([$goods_number, $zbz]);
        }
        $result['goods_number'] = $buy_number;
        return $result;
    }

    public function choose(Request $request)
    {
        $orderstr = $request->input('orderstr');
        if (empty($orderstr)) {
            $result['error']           = 0;
            $result['jp_total_amount'] = formated_price(0);;
            $result['total'] = formated_price(0);
            return $result;
        }
        $orderstrs = rtrim($orderstr, '_');
        $orderarrs = explode('_', $orderstrs);//购物车商品id集合
        Cache::tags($this->user->user_id)->forever('cart_list', $orderarrs);
        //return $orderarrs;
        $total                     = $this->model->where('user_id', $this->user->user_id)->where('goods_id', '!=', 0)->whereIn('rec_id', $orderarrs)
            ->sum(DB::raw('goods_price*goods_number'));
        $jp_total                  = DB::table('cart as c')->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')
            ->where('c.goods_id', '!=', 0)->where('c.user_id', $this->user->user_id)
            ->where('g.show_area', 'like', "%2%")->whereIn('c.rec_id', $orderarrs)
            ->sum(DB::raw('ecs_c.goods_price*ecs_c.goods_number'));
        $result['error']           = 0;
        $result['jp_total_amount'] = 0;
        $result['total']           = 0;
        $result['jp_total_amount'] = formated_price($jp_total);
        $result['total']           = formated_price($total);
        return $result;
    }

    public function addNum(Request $request)
    {
        $rec_id    = $request->input('rec_id');
        $number    = $request->input('num');
        $orderstr  = $request->input('orderstr');
        $orderstrs = rtrim($orderstr, '_');
        $orderarrs = explode('_', $orderstrs);//购物车商品id集合
        $num       = $request->input('change_num', 1);//增加的数量
        //$goods_info = cartGoods($user,[$rec_id],true);
        $goods_info       = $this->model->get_cart_goods($this->user, array($rec_id), 1);
        $result           = array();
        $result['error']  = 0;
        $result['rec_id'] = $rec_id;
        $zbz              = isset($goods_info->goods->zbz) ? $goods_info->goods->zbz : 1;//中包装
        $jzl              = isset($goods_info->goods->jzl) ? intval($goods_info->goods->jzl) : 0;//件装量

        if ($num == 1 || $num == -1) {
            $final_num    = $this->final_num($goods_info->goods->xg_num, $jzl, $zbz, $goods_info->goods->goods_number, $number, $num);
            $goods_number = $final_num['goods_number'];
            if (!empty($final_num['message'])) {
                $result['message'] = $final_num['message'];
            }
        } else {
            $final_num    = $this->final_num($goods_info->goods->xg_num, $jzl, $zbz, $goods_info->goods->goods_number, $num);
            $goods_number = $final_num['goods_number'];
        }
        $up_arr = ['goods_number' => $goods_number];
        if ($this->model->where('rec_id', $rec_id)->where('user_id', $this->user->user_id)->update($up_arr)) {
            //$cacheTotal = Cache::tags('cart_'.$user->user_id)->get('total');
            $total                     = $this->model->where('user_id', $this->user->user_id)->where('goods_id', '!=', 0)
                ->whereIn('rec_id', $orderarrs)->sum(DB::raw('goods_price*goods_number'));
            $jp_total                  = DB::table('cart as c')
                ->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')
                ->whereIn('rec_id', $orderarrs)
                ->where('c.goods_id', '!=', 0)
                ->where('c.user_id', $this->user->user_id)->where('g.show_area', 'like', "%2%")
                ->sum(DB::raw('ecs_c.goods_price*ecs_c.goods_number'));
            $goods_info->goods_number  = $goods_number;
            $result['num']             = $goods_number;
            $result['jp_total_amount'] = $jp_total;
            $result['total']           = $total;
            $result['subtotal']        = formated_price($goods_info->goods_price * $goods_number);
            $result['jp_total_amount'] = formated_price($result['jp_total_amount']);
            $result['total']           = formated_price($result['total']);
        } else {
            $result['num']   = $goods_number;
            $result['error'] = 1;
        }
        return $result;
    }

    public function jiesuan(Goods $goods, Shipping $shipping)
    {
        $addressId = $this->user->address_id;
        $rec_ids   = Cache::tags($this->user->user_id)->get('cart_list');
        $result    = $this->model->get_cart_goods($this->user, $rec_ids);
        if (!$rec_ids) {
            return redirect()->route('cart.index');
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
                tips($v->goods->goods_name . '库存不足', 1);
            }
            if ($v->goods_number > $v->goods->xg_num && $v->goods->xg_num > 0) {//超出限购数量
                tips($v->goods->goods_name . '超出限购数量', 1);
            }

            $goods_amount += $v->goods->real_price * $v->goods_number;

        }
        //收货地址
        $address = UserAddress::where(function ($query) use ($addressId) {
            $query->where('user_id', $this->user->user_id);
            if ($addressId > 0) {
                $query->where('address_id', $addressId);
            }
        })->first();
        if (!$address) {
            $address = UserAddress::where(function ($query) use ($addressId) {
                $query->where('user_id', $this->user->user_id);
            })->first();
        }
        if (!$address) {
            return redirect()->route('address.create');
        } elseif ($address->address_id !== $this->user->address_id) {
            $this->user->address_id = $address->address_id;
            $this->user->save();
        }
        $ids       = [$address->province, $address->city, $address->district];
        $area_name = get_region_name($ids, ' ');
        //物流
        $shipping_list = [];
        if ($this->user->shipping_id == 0) {
            $shipping_list = $shipping->shipping_list([$this->user->country, $this->user->province, $this->user->city, $this->user->district]);
        }
        $this->assign['shipping_list'] = $shipping_list;
        //支付方式
        $payment = Payment::where('enabled', 1)->select('pay_id', 'pay_name', 'pay_desc', 'is_cod')->orderBy('pay_order', 'desc')->get();

        /**
         * 活动相关结束
         */

        /**
         * 判断是否能使用账期
         */
        $shipping_fee                 = 0;
        $total                        = $goods_amount + $shipping_fee;
        $surplus                      = min([$this->user->user_money, $total]);
        $order_amount                 = $total - $surplus;
        $this->assign['goods_amount'] = $goods_amount;
        $this->assign['shipping_fee'] = 0;
        $this->assign['total']        = $total;
        $this->assign['surplus']      = $surplus;
        $this->assign['order_amount'] = $order_amount;
        $this->assign['page_title']   = '结算-';
        $this->assign['result']       = $result;
        $this->assign['area_name']    = $area_name;
        $this->assign['address']      = $address;
        $this->assign['payment']      = $payment;
        $this->assign['cartStep']     = "
        <li><img src='" . asset('images/cart_03.png') . "'/></li>
        <li><img src='" . asset('images/confirm2.png') . "'/></li>
        <li><img src='" . asset('images/cart_05.png') . "'/></li>
        ";
        return view('cart.jiesuan', $this->assign);
    }
}
