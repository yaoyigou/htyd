<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Goods;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $model;

    public $user;

    public $assign = [];

    public $sort;

    public $order;

    public $page_num;

    public function __construct(Cart $cart)
    {
        $this->model          = $cart;
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->user   = auth()->user();
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
        $cart->goods_price    = $goods_info->shop_price;
        $cart->is_real        = $goods_info->is_real;
        $cart->extension_code = $goods_info->extension_code;
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
    public function destroy($id)
    {
        //
    }
}
