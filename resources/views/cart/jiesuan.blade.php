@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/cart.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/confirm_order.css')}}" rel="stylesheet" type="text/css"/>
<style>
    .table7 tr td {
        width: 20%;
    }

    .table7 tr td .check {
        display: none;
    }

    .table7 tr td .check-bg {
        display: block;
    }
</style>
@endpush
@section('content')
    @include('cart.header')
    @component('component.form',['action'=>route('order.store'),'method'=>'post'])
        <div class="content_1">
            <div class="content_1_top">
                <div class="left"><h3>确认订单信息</h3></div>
                <div class="right"> 四川满 <span class="text">800</span> 元即可免运费</div>
            </div>
            <table class="table1" cellpadding="0" cellspacing="0">
                <tr style="background-color: #f5f5f5">
                    <th colspan="5">商品列表</th>
                    <th colspan="4"><a href="{{route('cart.index')}}">返回修改购物车 </a></th>
                </tr>
                <tr class="title">
                    <td class="tb1_td1">商品名称</td>
                    <td class="tb1_td2">生产厂家</td>
                    <td class="tb1_td3">药品规格</td>
                    <td class="tb1_td4" style="width: 100px;">效期</td>
                    <td class="tb1_td9" style="width: 130px;">国药准字</td>
                    <td class="tb1_td5">建议零售价</td>
                    <td class="tb1_td6">单价</td>
                    <td class="tb1_td7"> 数量</td>
                    <td class="tb1_td8">小计</td>
                </tr>
                @foreach($result as $v)
                    <tr>
                        <td class="tb1_td1">
                    <span class="small_img">
                        <a href="{{$v->goods->goods_url}}" target="_blank"><img src="{{$v->goods->goods_thumb}}"
                                                                                title="{{$v->goods->goods_name}}"/></a>
                    </span>
                            <span class="txt">{{$v->goods->goods_name}}</span>
                        </td>
                        <td class="tb1_td2" style="width: 120px;">

                            <span class="txt">{{$v->goods->sccj}}</span>
                        </td>
                        <td class="tb1_td3">

                            <span class="txt">{{$v->goods->spgg}}</span>
                        </td>

                        <td class="tb1_td4">

                        <span class="txt"
                              @if($v->goods->is_xq_red==1) style="color:#e70000;" @endif>{{$v->goods->xq}}</span>
                        </td>
                        <td class="tb1_td9">

                            <span class="txt">{{$v->goods->gyzz}}</span>
                        </td>
                        <td class="tb1_td5">{{formated_price($v->goods->market_price)}}</td>
                        <td class="price tb1_td6">{{formated_price($v->goods->real_price)}}</td>
                        <td class="tb1_td7">{{$v->goods_number}}</td>
                        <td class="tb1_td8">{{formated_price($v->goods->real_price*$v->goods_number)}}</td>
                    </tr>
                @endforeach
            </table>
            {{--<!-- 礼品列表 end -->--}}
            <table class="table22" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                {{--<tr>--}}
                {{--<th colspan="2">收货人信息<a href="{{route('address.edit')}}">修改</a></th>--}}
                {{--</tr>--}}
                <tr>
                    <td class="tb22_td12"><img src="{{path('images/confirm4.png')}}" alt=""/></td>
                    <td class="tb22_td22">
                        <p class="address">
                            <input type="radio" name="address_id" value="{{$address->address_id}}" checked="checked"/>
                            <span class="country">
						中国&nbsp; {{$area_name}}
						</span>
                            <span class="adds">{{$address->address}}</span> （ <span
                                    class="name">{{$address->consignee}}</span> <span>收</span>)
                        </p>
                        <p class="msg">
                            <span class="title_name">手机：</span> <span class="text">{{$address->tel}}</span>
                            <span class="title_name">电子邮件地址：</span> <span class="text">{{$address->email}}</span>
                            @if($address->zipcode)<span class="title_name">邮政编码：</span> <span
                                    class="text">{{$address->zipcode}}</span>@endif
                            @if($address->mobile)<span class="title_name">电话：</span> <span
                                    class="text">{{$address->mobile}}</span>@endif
                            @if($address->best_time)<span class="title_name">最佳送货时间：</span> <span
                                    class="text">{{$address->best_time}}</span>@endif
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table3" cellpadding="0" cellspacing="0" id="shippingTable">
                <tr>
                    <th><p style="background-color: #f5f5f5">配送方式</p></th>
                </tr>
                <tr>
                    <td class="sel">
                        @if($user->shipping_id!=0&&!empty($user->shipping_name))
                            <span class="name">物流：<span class="text">{{$user->shipping_name}}</span></span>
                            @if($user->wl_dh!='')
                                <span class="name">物流电话：<span class="text">{{$user->wl_dh}}</span></span>
                            @endif
                            <input type="hidden" name="shipping_id" value="{{$user->shipping_id}}"/>
                            <input type="hidden" name="ps_wl" id="ps_wl" value="{{$user->shipping_name}}"/>
                            <input type="hidden" name="ps_dh" id="ps_dh" value="{{$user->wl_dh}}"/>
                        @else
                            <p class="ways">
                                {{--循环配送方式--}}
                                @foreach($shipping_list as $k=>$v)
                                    <label for="list{{$k}}" title="{{$v->shipping_name}}" alt="{{$v->shipping_name}}">
                                        <input name="shipping" type="radio" value="{{$v->shipping_id}}"
                                               supportCod="{{$v->support_cod or ''}}"
                                               insure="{{$v->insure or ''}}"
                                               onclick="selectShipping(this)"
                                               id="ps_{{$k}}"
                                               checked/>{{str_limit($v->shipping_name,20)}}
                                    </label>
                                @endforeach
                                <label for="list6"><input name="shipping_id" type="radio" value="-1"
                                                          @if(count($shipping_list)==0) checked @endif/>其它物流</label>
                            </p>
                            @if(count($shipping_list)==0)
                                <p class="other" id="ps_fs" style="display: inline-block">
                                    <span class="title">物流公司名称:</span> <input type="text" name="ps_wl" class="texts"
                                                                              id="ps_wl"/>
                                    <span class="title">物流电话:	</span> <input type="text" name="ps_dh" class="texts"
                                                                                id="ps_dh"/>
                                </p>
                            @endif
                        @endif
                        <p class="tip">
                            <b>(温馨提示：请谨慎填写，配送方式填写后只能让客服修改，所有货物请在送货员在场时开箱验货再签收，如有破损及时联系客服人员，如未当面开箱验货，破损不予赔付，自行承担。)</b>
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table5" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5">发票类型<span style="color: #e70000;margin-left: 10px;">(发票选择后只能由客服人员修改，如需修改请联系客服。)</span>
                        </p></th>
                </tr>
                <tr>
                    <td>
                        <p class="fn_clear" style="padding: 10px;">
                            <label>
                                <input checked="checked" name="dzfp" value="0" type="radio">
                                <span>增值税普通发票</span>
                            </label>
                        </p>
                        <p class="fn_clear" style="padding: 10px;">
                            <label>
                                <input name="dzfp" value="2" type="radio">
                                <span>增值税专用发票</span>
                            </label>
                            <span style="color: #e70000;">(如果选择了增值税专用发票，请下载开增值税专票需要信息，填好信息后打印盖上公章截图给客服人员。)</span>
                            {{--<a href="/uploads/开增值税专票需要信息.doc"--}}
                               {{--style="padding: 1px 10px;color:#fff;background-color: #39A817;margin-left: 30px;border-radius: 5px;">下载</a>--}}
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table5" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5">其他信息</p></th>
                </tr>
                <tr>
                    <td>
                        <textarea name="postscript" id="postscript" style="height: 35px;"></textarea>
                    </td>
                </tr>
            </table>
            <table class="table4" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5;width: 1196px;">支付方式</p></th>
                </tr>
                <tr>
                    <td class="tb4_td1">
                        <span class="title"> 商品总金额：</span><span id="total1"
                                                                class="price">{{formated_price($total)}}</span>
                    </td>


                </tr>
                <tr>
                    <td class="tb4_td2" style="padding-bottom: 10px;">
                    <span class="title">  使用余额：<input name="surplus" type="hidden" class="text" id="ECS_SURPLUS"
                                                      size="10" value="{{$surplus}}"/></span><span class="price"
                                                                                                   id="surplus">{{formated_price($surplus)}}</span>
                        （<span class="title"> 当前余额：</span><span class="price"
                                                                id="J_surplus">{{formated_price($user->user_money)}}</span><span
                                class="price" id="ECS_SURPLUS_NOTICE" class="notice"></span></span>）

                    </td>
                </tr>
                @if($order_amount>0)

                    @foreach($payment as $k=>$v)
                        <tr>
                            <td colspan="4" class="pay_way">
                                <p class="fn_clear" @if(count($payment)==($k+1)) style="margin-bottom: 10px;" @endif>
                                    <input type="radio" name="payment" value="{{$v->pay_id}}" @if($k==0) checked
                                           @endif  isCod="{{$v->is_cod}}" onclick="selectPayment(this)" id="ag_{{$k}}"/>
                                    @if($v->pay_name=='支付宝转账')
                                        <label for="ag_{{$k}}"><img alt="支付宝转账"
                                                                    src="{{get_img_path('images/zfbzz.jpg')}}"
                                                                    original="{{get_img_path('images/zfbzz.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">转账成功后请及时联系客服人员确认</span>
                                    @elseif($v->pay_name=='财付通')
                                        <label for="ag_{{$k}}"><img src="{{path('images/cft.jpg')}}"
                                                                    original="{{path('images/cft.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='paypal')
                                        <label for="ag_{{$k}}"><img src="{{path('images/bank_paypal.jpg')}}"
                                                                    original="{{path('images/bank_paypal.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='银行汇款/转帐')
                                        <label for="ag_{{$k}}"><img alt="银行汇款/转帐" src="{{path('images/yhhk.jpg')}}"
                                                                    original="{{path('images/yhhk.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label><span
                                                class="tip_txt yinhang"><a href="/articleInfo?id=49"
                                                                           target="_blank">查看帐户</a></span>
                                    @elseif($v->pay_name=='余额支付')
                                        <label for="ag_{{$k}}"><img src="{{path('images/yezf.jpg')}}"
                                                                    original="{{path('images/yezf.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='货到付款')
                                        <label for="ag_{{$k}}"><img src="{{path('images/hdfk.jpg')}}"
                                                                    original="{{path('images/hdfk.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='银联在线支付')
                                        <label for="ag_{{$k}}"><img alt="银联在线支付" src="{{path('images/yinlian01.jpg')}}"
                                                                    original="{{path('images/yinlian01.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，单笔限额2万，单日限额5万</span>
                                    @elseif($v->pay_name=='农行在线支付')
                                        <label for="ag_{{$k}}"><img width='200' src="{{path('images/abcicon2.jpg')}}"
                                                                    original="{{path('images/abcicon2.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='快捷支付')
                                        <label for="ag_{{$k}}"><img alt="快捷支付" src="{{get_img_path('images/xyyh.jpg')}}"
                                                                    original="{{get_img_path('images/xyyh.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a
                                                    style="font-size:14px;font-weight:bold;color:#e70000 !important;"
                                                    href="/uploads/快捷支付支持银行列表.xlsx">支付方式及开通方式</a></span>
                                    @elseif($v->pay_name=='微信扫码支付')
                                        <label for="ag_{{$k}}"><img alt="微信扫码支付"
                                                                    src="{{get_img_path('images/weixin.jpg')}}"
                                                                    original="{{get_img_path('images/xyyh.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a target="_blank"
                                                                                        style="font-size:14px;font-weight:bold;color:#e70000 !important;"
                                                                                        href="https://kf.qq.com/touch/sappfaq/151210EJfUZZ151210qq2yUn.html?scene_id=kf1&platform=14">支付限额查看</a></span>
                                    @elseif($v->pay_name=='支付宝扫码支付')
                                        <label for="ag_{{$k}}"><img alt="支付宝扫码支付" src="{{get_img_path($v->pay_desc)}}"
                                                                    original="{{get_img_path($v->pay_desc)}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡</span>
                                    @else
                                        {{$v->pay_name}}
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <input name="payment" type="radio" value="7" checked="checked" style="display:none"/>
                @endif
            </table>
            <div id="ECS_ORDERTOTAL">
                <table class="table8" align="center" border="0" cellpadding="0">
                    <tr>
                        <th><p style="background-color: #f5f5f5">费用总计</p></th>
                    </tr>
                    <tr class="tb6_td1">
                        <td>
                            <p><span class="price" id="total" data="{{$total}}">{{formated_price($total)}}</span> <span
                                        class="title">商品总金额: </span></p>
                            <p id='shipping_fee'><span
                                        class="price">{{formated_price($shipping_fee)}}</span><span class="title"><span
                                            style="color: #E70000">+</span>&nbsp;物流费用: </span></p>
                            @if($surplus>0)
                                <p><span class="price" id="user_surplus"
                                         data="{{$surplus}}">{{formated_price($surplus)}}</span><span
                                            class="title"><span
                                                style="color: #E70000">-</span>&nbsp;使用余额: </span></p>
                            @endif
                        </td>
                    </tr>

                </table>
            </div>
            <table class="table6" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="tb6_td2">
                        {{--<span style="color: red;margin-right: 80px;">提示：3.8日当天累计采购金额每满1000送券1张，活动结束后统一返到账户。</span>--}}
                        <span class="title subhide">应付款金额：</span> <span class="price subhide" id="amount"
                                                                        data="{{$goods_amount}}">
                                    {{formated_price($goods_amount)}}
                            </span>
                        <input type="submit" class="submit" value="提交订单>" id="tjdd"/>
                        <span style="color: #ef0000;display: none;font-size: 16px;" class="submit_txt" id="tjdd_text">订单正在提交中...</span>
                    </td>
                </tr>
            </table>
        </div>
    @endcomponent
    @push('footer')
    <script type="text/javascript">
        $('#tjdd').click(function () {
            $(this).hide();
            $('#tjdd_text').show();
        })
    </script>
    @endpush
    @include('layouts.footer')
@endsection
