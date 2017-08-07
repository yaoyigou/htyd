@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/order_msg2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            @component('component.user')
                @slot('title1')
                    交易管理
                @endslot
                @slot('title2')
                    {{route('order.index')}}
                @endslot
                @slot('title3')
                    我的订单
                @endslot
                <table class="table1">
                    <tr>
                        <th colspan="2">订单状态</th>

                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">订单号：</td>
                        <td>{{$info->order_sn}}</td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">订单状态：</td>
                        <td>{{os($info->order_status)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">付款状态：</td>
                        <td>
                            {{--<div style="width: 150px; float: right; height: 50px;">--}}
                            {{--<a href="{{route('article',['id'=>91])}}" class="payonline_notice" target="_blank"--}}
                            {{--style=" font-size: 14px; color: #39a817; display: inline; line-height: 50px; margin-right: 20px;">银联在线支付说明</a>--}}
                            {{--</div>--}}
                            <div style='width:450px;float:left;height:50px;'>
                                <span style="line-height: 50px;">{{ps($info->pay_status)}}</span>
                                {!! $unionpay or '' !!}
                                {{--{!! $abcpay or '' !!}--}}
                                {!! $xyyh or '' !!}
                                {!! $weixin or '' !!}
                                {!! $alipay or '' !!}
                                @if($info->is_mhj==2&&$info->order_id>380700)
                                    <span style="line-height: 50px;margin-left: 10px;color:red;">(该订单含血液制品，请法人转款到公司对公账户！)</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">配送状态：</td>
                        <td>{{ss($info->shipping_status)}}&nbsp;&nbsp;&nbsp;&nbsp;
                            @if(strpos($info->fhwl_m,'宅急送')!==false&&$info->shipping_status>=4)
                                <a target="_blank"
                                   href="{{route('zjs',['id'=>$info->order_id,'is_zq'=>$info->is_zq,'is_separate'=>$info->is_separate])}}">物流跟踪</a>
                            @endif
                        </td>
                    </tr>
                    @if($info->invoice_no)
                        <tr>
                            <td class="tb1_td1 al_right">发货物流公司名：</td>
                            <td>{{$info->fhwl_m}}</td>
                        </tr>
                        <tr>
                            <td class="tb1_td1 al_right">发货物流公司电话：</td>
                            <td>{{$info->fhwl_d}}</td>
                        </tr>
                        <tr>
                            <td class="tb1_td1 al_right">物流单号：</td>
                            <td>{{$info->invoice_no}}</td>
                        </tr>

                        <tr>
                            <td class="tb1_td1 al_right">发货件数：</td>
                            <td>{{$info->send_num}}</td>
                        </tr>
                        <tr>
                            <td class="tb1_td1 al_right">发货时间：</td>
                            <td>{{date('Y-m-d H:i:s',$info->shipping_time)}}</td>
                        </tr>
                    @endif
                    @if($info->to_buyer)
                        <tr>
                            <td class="tb1_td1 al_right">给商家留言：</td>
                            <td>{{$info->to_buyer}}</td>
                        </tr>
                    @endif
                </table>
                <table class="table2">
                    <tr>
                        <th class="case1" colspan="7">商品列表</th>
                    </tr>
                    <tr class="title">
                        <td class="tb2_td6">商品标识</td>
                        <td class="tb2_td1">商品名称</td>
                        <td class="tb2_td7">效期</td>
                        <td class="tb2_td2">商品价格</td>
                        <td class="tb2_td3">数量</td>
                        <td class="tb2_td4">小计</td>
                        <td class="tb2_td5">操作</td>
                    </tr>
                    @foreach($info->order_goods as $v)
                        <tr>
                            <td class="tb2_td6" style="color:#3ebb2b;cursor:pointer;position:relative;z-index: 1">
                                @if($v->is_jp==1)
                                    精
                                    <div class="tip-box"
                                         style="border:1px solid #e5e5e5;border-radius:5px;line-height:24px;padding:5px;position:absolute;width:180px;color:#666;top:-28px;left:54px;background-color:#fff;border-left:4px solid #6C0;display:none;z-index:999;text-align:left;">
                                        此商品为精品专区商品
                                    </div>
                                @elseif($v->zyzk>0)
                                    惠
                                    <div class="tip-box"
                                         style="border:1px solid #e5e5e5;border-radius:5px;line-height:24px;padding:5px;position:absolute;width:180px;color:#666;top:-28px;left:54px;background-color:#fff;border-left:4px solid #6C0;display:none;z-index:999;text-align:left;">
                                        此商品优惠{{formated_price($v->zyzk)}}
                                    </div>
                                @endif
                            </td>
                            <td class="tb2_td1">
                                <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank"
                                   style="color: #FF6102">{{$v->goods_name}}</a>
                            </td>
                            <td class="tb2_td7">{{$v->xq}}</td>
                            <td class="tb2_td2">{{formated_price($v->goods_price)}}</td>
                            <td class="tb2_td3">{{$v->goods_number}}</td>
                            <td class="tb2_td4">{{formated_price($v->goods_price*$v->goods_number)}}</td>
                            <td class="tb2_td5"><a @if($user->ls_review==1) onclick="tocart({{$v->goods_id}})"
                                                   @else onclick="tocart1()" @endif>加入购物车</a>
                            </td><!-- 2015-7-9 -->
                        </tr>
                        @if($v->user_bz)
                            <tr>
                                <td colspan="7" style="color:#F00; font-size:12px;" bgcolor="#ffffff" align="left">
                                    备注：{{$v->user_bz}}(下单数量：{{$v->goods_number_f or 0}})
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td class="al_right com" colspan="7">
                            <form action="{{route('order.update', ['id' => $info->order_id])}}" method="post"
                                  name="formFee"
                                  id="formFee"
                                  style="float: right;width: 80px;height: 39px;margin-left: 20px;@if($info->order_status==1&&$info->pay_status==2&&$info->shipping_status==4)display: block;@else display: none; @endif">
                                <input type="submit" name="Submit" class="submit_1" value="确认收货"
                                       style="margin-top: 5px;"/>
                                <input type="hidden" name="act" value="qrsh"/>
                                {!! csrf_field() !!}
                            </form>
                            <span style="width: 200px;height: 39px;display: block;float:right;">
                        商品总价:<span class="price">{{formated_price($info->goods_amount)}}</span>
                        </span>


                        </td>

                    </tr>
                </table>

                <table class="table3">
                    <tr>
                        <th>费用总计</th>
                    </tr>
                    <tr>
                        <td class="al_right com">
                            商品总价:{{formated_price($info->goods_amount)}}
                            @if($info->discount>0)
                                - 折扣:{{formated_price($info->discount)}}
                            @endif
                            @if($info->shipping_fee>0)
                                + 物流费用:{{formated_price($info->shipping_fee)}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="al_right com">
                            @if($info->money_paid>0)
                                - 已付款金额:<span class="price">{{formated_price($info->money_paid)}}</span>
                            @endif
                            @if($info->surplus>0)
                                - 使用余额:<span class="price">{{formated_price($info->surplus)}}</span>
                            @endif
                            @if($info->pack_fee>0)
                                - 使用优惠券:<span class="price">{{formated_price($info->pack_fee)}}</span>
                            @endif
                            @if($info->zyzk>0)
                                - 优惠金额:<span class="price">{{formated_price($info->zyzk)}}</span>
                            @endif
                            @if($info->jnmj>0)
                                - 使用充值余额:<span class="price">{{formated_price($info->jnmj)}}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="al_right com">
                            应付款金额: <span class="price">{{formated_price($info->order_amount)}}</span>
                            {{--<!-- {if $info.extension_code eq "group_buy"} --><br />--}}
                            {{--{$lang.notice_gb_order_amount}--}}
                            {{--<!-- {/if} --></span>--}}
                        </td>
                    </tr>
                    @if($info->is_mhj==0&&$info->order_amount>0&&$info->is_zq==0&&$info->jnmj==0&&$info->is_separate==0)
                        <tr>
                            <td class="al_right com">
                                <form action="{{route('user.useSurplus')}}" method="post" name="formFee" id="formFee">
                                    追加使用余额:
                                    <input name="surplus" type="text" size="8" value="0"
                                           style="border:1px solid #ccc;"/>（您的帐户余额：{{formated_price($user->user_money)}}
                                    ）
                                    <input type="submit" name="Submit" class="submit_1" value="确定"/>
                                    <input type="hidden" name="orderId" value="{{$info->order_id}}"/>
                                    {!! csrf_field() !!}
                                </form>
                            </td>
                        </tr>
                    @endif
                </table>
                <table class="table4">
                    <tr>
                        <th colspan="4">收货人信息</th>
                    </tr>
                    <tr>
                        <td class="al_right tb4_td1">收货人姓名：</td>
                        <td class="tb4_td2">{{$info->consignee}}</td>
                        <td class="al_right tb4_td3">电子邮件地址：</td>
                        <td class="tb4_td4">{{$info->email}}</td>
                    </tr>
                    <tr>
                        <td class="al_right tb4_td1">详细地址：</td>
                        <td colspan="3">{{$info->address}}
                            @if($info->zipcode)
                                [邮政编码: {{$info->zipcode}}]
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="al_right tb4_td1">手机：</td>
                        <td class="tb4_td2">{{$info->tel}}</td>
                        <td class="al_right tb4_td3">电话：</td>
                        <td class="tb4_td4">{{$info->mobile}}</td>

                    </tr>
                    <tr>
                        <td class="al_right tb4_td1">备注：</td>
                        <td class="tb4_td2">{{$info->sign_building}}</td>
                        <td class="al_right tb4_td3">最佳送货时间：</td>
                        <td class="tb4_td4">{{$info->best_time}}</td>

                    </tr>


                </table>
                <table class="table5">
                    <tr>
                        <th>支付方式</th>
                    </tr>
                    <tr>
                        <td>所选支付方式: {{$info->pay_name}}。应付款金额:
                            <strong>{{formated_price($info->order_amount)}}</strong><br/>
                            {!! $info->pay_desc !!}</td>
                    </tr>
                </table>
                <table class="table6">
                    <tr>
                        <th colspan="3">其他信息</th>
                    </tr>
                    @if($info->shipping_id>0)
                        <tr>
                            <td class="al_right tb6_td1">配送方式：</td>
                            <td class="tb6_td2" colspan="3">{{$info->shipping_name}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="al_right tb6_td1">支付方式：</td>
                        <td class="tb6_td2" colspan="3">{{$info->pay_name}}</td>
                    </tr>
                    @if($info->postscript)
                        <tr>
                            <td class="al_right tb6_td1">订单附言：</td>
                            <td class="tb6_td2" colspan="3">{{$info->postscript}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="al_right tb6_td1">缺货处理：</td>
                        <td class="tb6_td2" colspan="3">{{$info->how_oos}}</td>
                    </tr>
                </table>
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
