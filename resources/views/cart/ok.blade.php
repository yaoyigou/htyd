@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/cart.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/confirm_order.css')}}" rel="stylesheet" type="text/css"/>
<style>
    .back_a a {
        text-align: center;
        border-radius: 5px;
        color: #fff;
        background-color: #33cc33;
        margin: 0 5px;
        padding: 2px 10px;
    }

    .back_a a.home {
        padding: 2px 20px;
    }

    #J_payonline {
        width: 110px;
        height: 36px;
        color: #fff;
        text-align: center;
        line-height: 26px;
        background-color: #33cc33;
        border-radius: 5px;
        font-size: 16px;
        margin-left: 0px;
        *margin-left: 0px;
        cursor: pointer;
        position: absolute;
        left: 200px !important;
        top: -29px;

    }
</style>
@endpush
@section('content')
    @include('cart.header')
    <div class="content_2" style="position: relative;">

        <div class="ico"><img src="{{path('images/order33.png')}}" alt=""/></div>
        <div class="info-box">
            <div class="title-txt">感谢您在本店购买商品，订单已成功提交！</div>
            <div class="info">
                <p> <span class="box"><span class="title">您的订单号：</span>
                <a href="{{route('order.show',['id'=>$info->order_id])}}" target="_blank"
                   class="important-info">{{$info->order_sn}}</a>&nbsp; &nbsp; &nbsp;
            </span></p>
                <p><span class="box"><span class="title">商品总金额：</span><span
                                class="important-info price_txt">{{formated_price($info->goods_amount)}}</span></span>
                </p>
                <p @if($info->shipping_fee<=0) style="display: none;" @endif id='shipping_fee'><span
                            class="box"><span class="title">物流费用：</span><span class="important-info price_txt">{{formated_price($info->shipping_fee)}}
                            (四川省内单张订单满800包邮)</span></span></p>
                @if($info->surplus>0)
                    <p><span class="box"><span class="title">使用余额：</span><span
                                    class="important-info price_txt">{{formated_price($info->surplus)}}</span></span>
                    </p>
                @endif
                <p><span class="box"><span class="title">应付总金额：</span><span
                                class="important-info price_txt">{{formated_price($info->order_amount)}}</span></span>
                </p>
                <div style="position: relative;margin: 5px 0px;">   <span class="box"><span class="title" style="font-size: 16px;
color: rgb(60, 60, 60);">支付方式：</span> <span class="important-info">{{$info->pay_name}}</span>
                    </span>
                    @if($info->order_amount>0)
                        {!! $online_pay !!}
                    @endif
                </div>
                <div class="fn_clear">
                   <span style="height: 28px;
display: block;
float: left;
width: 83px;
font-size: 16px;
color: red;
line-height: 28px;">温馨提示：</span>
                    <p style="float: left;line-height: 28px;">为保证你所选的商品库存，请尽快付款，未付款订单系统会在 <span class="important-info">24小时以后 </span>自动取消。
                    </p>
                    <p style="float: left;line-height: 28px;color: red;margin-left: 83px;">
                        为了您的货款安全，请不要将货款转到公司指定以外的账户！</p>
                </div>
                {{--@if(isset($order['order_sn_mhj']))--}}
                {{--<div style="color: red">--}}
                {{--温馨提示：根据GSP规定，该订单:{{$order['order_sn_mhj']}}只能单独转款，支持使用在线支付及转账到对公账户,并且含麻订单不能使用余额。--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--<div style="font-size: 16px; color: red; margin-bottom:10px;">温馨提示:为了您的货款安全,请不要将货款转到公司指定以外的账户!</div>--}}
            </div>
            <div class="back_a">
                返回 <a href="{{route('index')}}" class="home" style="font-size: 16px;">首页</a> 或者返回 <a
                        style="font-size: 16px;" href="{{route('user.index')}}">我的药易购</a>查看或跟踪订单
            </div>
        </div>
    </div>
    <div class="alert_mark" style="display:none;">
        <div class="content_l">
            <div class="mark_box">
                <span class="close"> </span>
                <p class="feed_back">支付反馈</p>
                <div class="info_m">
                    <p>请您在新打开的网上银行页面进行支付，支付完成后选择：</p>
                    <p class="text"><span class="suc_ico ico"></span> 支付成功： <a
                                href="{{route('order.show',['id'=>$info->order_id])}}">查看订单</a> <a
                                href="{{route('index')}}">继续购物</a></p>
                    <p class="text"><span class="fail_ico ico"></span> 支付失败： <a
                                href="{{route('article.show',['id'=>49])}}">查看支付帮助</a></p>
                </div>


            </div>
        </div>
    </div>
    <div class="content_mark_div"></div>
    @include('layouts.footer')
@endsection
