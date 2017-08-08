@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/cart.css')}}" rel="stylesheet" type="text/css" />
<link href="{{path('css/confirm_order.css')}}" rel="stylesheet" type="text/css" />
<style>
    .table7 tr td{width: 20%;}
    .table7 tr td .check{display: none;}
    .table7 tr td .check-bg{display: block;}
</style>
@endpush
@section('content')
    @include('cart.header')
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
                    @if($user->shipping_id!=0)
                        <span class="name">物流：<span class="text">{{$user->shipping_name}}</span></span>
                        @if($user->wl_dh!='')
                            <span class="name">物流电话：<span class="text">{{$user->wl_dh}}</span></span>
                        @endif
                        <input type="hidden" name="shipping_id" value="{{$user->shipping_id}}"/>
                        <input type="hidden" name="ps_wl" id="ps_wl" value="{{$user->shipping_name}}"/>
                        <input type="hidden" name="ps_dh" id="ps_dh" value="{{$user->wl_dh}}"/>
                        <input type="hidden" name="shipping" value="{{$user->shipping_id}}" checked="checked"/>
                    @else
                        <p class="ways">
                            {{--循环配送方式--}}
                            @foreach($shipping as $k=>$v)
                                @if($v->shipping_id==9)
                                    <label for="list{{$k}}"><input name="shipping" type="radio"
                                                                   value="{{$v->shipping_id}}"
                                                                   supportCod="{{$v->support_cod or ''}}"
                                                                   insure="{{$v->insure or ''}}"
                                                                   onclick="selectShipping(this)"
                                                                   id="ps_{{$k}}"/>{{$v->shipping_name}}
                                        <select name="area_name" id="area_name">
                                            <option value='0'>请选择...</option>
                                            <option value='都江堰'>都江堰</option>
                                            <option value='邛崃'>邛崃</option>
                                            <option value='金堂'>金堂</option>
                                            <option value='双流'>双流</option>
                                            <option value='简阳'>简阳</option>
                                            <option value='郫县'>郫县</option>

                                            <option value='新津'>新津</option>

                                            <option value='仁寿'>仁寿</option>
                                            <option value='新都'>新都</option>
                                            <option value='彭州'>彭州</option>
                                            <option value='什邡'>什邡</option>
                                            <option value='绵阳'>绵阳</option>
                                            <option value='德阳'>德阳</option>
                                            <option value='温江'>温江</option>
                                            <option value='青白江'>青白江</option>
                                            {{--<option value='江油' >江油</option>--}}
                                        </select>
                                    </label>
                                @elseif($v->shipping_id==13)
                                    <label for="list{{$k}}"><input name="shipping" type="radio"
                                                                   value="{{$v->shipping_id}}"
                                                                   supportCod="{{$v->support_cod or ''}}"
                                                                   insure="{{$v->insure or ''}}"
                                                                   onclick="selectShipping(this)"/>{{$v->shipping_name}}
                                        <select name="kf_name" id="kf_name">
                                            <option value='郫县库房'>郫县库房</option>
                                        </select>
                                    </label>
                                @else
                                    <label for="list{{$k}}" title="{{$v->shipping_name}}"
                                           alt="{{$v->shipping_name}}"><input name="shipping" type="radio"
                                                                              value="{{$v->shipping_id}}"
                                                                              @if($v->shipping_id==12)data-val="{$district_name}的配送区域为：{$zjs_townlist_str}"
                                                                              @endif  supportCod="{{$v->support_cod or ''}}"
                                                                              insure="{{$v->insure or ''}}"
                                                                              onclick="selectShipping(this)"
                                                                              id="ps_{{$k}}"
                                                                              checked/>{{str_limit($v->shipping_name,20)}}@if($v->shipping_id==12)
                                            <a style="float:left;margin-left:10px;display:inline;font-family:'Microsoft yahei';font-weight:normal;color:#4E9249;"
                                               href="http://www.hezongyy.com/upload/%E5%AE%85%E6%80%A5%E9%80%81%E6%9C%8D%E5%8A%A1%E5%8C%BA%E5%9F%9F%E8%A1%A8.xls">宅急送配送区域表</a>@endif
                                    </label>
                                @endif
                            @endforeach
                            <label for="list6"><input name="shipping" type="radio" value="-1" {if $order.shipping_id eq
                                                      $shipping.shipping_id}checked="true" {/if}
                                supportCod="{$shipping.support_cod}" insure="{$shipping.insure}"
                                onclick="selectShipping(this)" id="qt" />其它物流</label>
                        </p>
                    @endif
                    @if($user->shipping_id==0)
                        <p class="other" id="ps_fs">
                            <span class="title">物流公司名称:</span> <input type="text" name="ps_wl" class="texts"
                                                                      id="ps_wl"/>
                            <span class="title">物流电话:	</span> <input type="text" name="ps_dh" class="texts"
                                                                        id="ps_dh"/>
                        </p>
                    @endif
                    <p class="tip">
                        <b>(温馨提示：请谨慎填写，配送方式填写后只能让客服修改，所有货物请在送货员在场时开箱验货再签收，如有破损及时联系客服人员，如未当面开箱验货，破损不予赔付，自行承担。)</b></p>
                </td>
            </tr>
        </table>
        <table class="table5" cellpadding="0" cellspacing="0">
            <tr>
                <th><p style="background-color: #f5f5f5">发票类型<span style="color: #e70000;margin-left: 10px;">(发票选择后只能由客服人员修改，如需修改请联系客服。)</span>
                    </p></th>
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
                    <span class="title"> 商品总金额：</span><span id="total1" class="price">{{formated_price($goods_amount)}}</span>
                </td>


            </tr>
        </table>
        <div id="ECS_ORDERTOTAL">
            <table class="table8" align="center" border="0" cellpadding="0">
                <tr>
                    <th><p style="background-color: #f5f5f5">费用总计</p></th>
                </tr>
                <tr class="tb6_td1">
                    <td>
                        <p><span class="price" id="total" data="{{$goods_amount+$shipping_fee}}">{{formated_price($goods_amount+$shipping_fee)}}</span> <span
                                    class="title">商品总金额: </span></p>
                        <p @if($shipping_fee<=0) style="display: none;" @endif id='shipping_fee'><span
                                    class="price">{{formated_price($shipping_fee)}}</span><span class="title"><span
                                        style="color: #E70000">+</span>&nbsp;物流费用: </span></p>
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
                    <input type="hidden" id="your_surplus" value="{{$user->user_money}}">
                    <input type="hidden" id="total_amount" value="{{$goods_amount}}">
                    {!! csrf_field() !!}
                </td>
            </tr>
        </table>
    </div>
    @include('layouts.footer')
@endsection
