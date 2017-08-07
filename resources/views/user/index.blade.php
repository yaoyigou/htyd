@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/slides.jquery.js')}}"></script>
<script type="text/javascript" src="{{path('js/my_order.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>

<style>
    .main .main_left {
        border-right: 0;
    }

    .main {
        margin-top: 12px;
    }

    .ddgz-alert {
        margin-left: -90px !important;
    }

    .hover_underline:hover {
        text-decoration: underline;
    }
</style>
@endpush
@push('footer')
<script type="text/javascript">
    //滚动播放
    $(function () {
        $('#slides').slides({
            container: 'slides_container',
            preload: true,
            play: 3000,
            pause: 1500,
            hoverPause: true,
            effect: 'slide',
            slideSpeed: 850
        });
    })
</script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')

    <div class="main fn_clear">

        @include('layouts.user_menu')

        <div class="main_mid">
            <ul class="fn_clear ul_list">
                <a href="{{route('user.account_log')}}" style="color: #666;">
                    <li><span class="ico_com ico_1"></span>余额<p>{{formated_price($user->user_money)}}</p></li>
                </a>
                <a href="./" style="color: #666;">
                    <li><span class="ico_com ico_2"></span>可用积分<p>{{$user->pay_points}}分</p></li>
                </a>
                <li><span class="ico_com ico_3"></span>消费总金额<p>{{formated_price($pay_amount)}}</p></li>
                <li class="end"><span class="ico_com ico_4"></span>待付款金额<p>{{formated_price($wait_amount)}}</p></li>
            </ul>
            <div class="infor">
                <div class="title_name"><a class="hover_underline" href="{{route('youhuiq.index')}}"
                                           style="font-size: 18px;color: #FF6102;">优惠券管理&nbsp;&gt;&gt;</a></div>
            </div>
            <div class="infor">
                <div class="title_name"><h4>会员信息</h4> <span class="name">{{$user->user_name}}</span> <span class="txt">(精品专区可兑换积分:{{$user->jp_points}}
                        )</span> <span class="medal"></span></div>
                <table>
                    @if($user->user_rank==2)
                        <tr class="first">
                            <td><span class="title">您的委托书已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td><span class="title">营业执照</span> @if($yyzz_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yyzz_time))
                                    ({{$user->yyzz_time}})@endif</td>
                            <td><span class="title">药品经营许可证</span> @if($xkz_time==1)未过期@else<font style="color:#f00;">已过期</font>@endif @if(!empty($user->xkz_time))
                                    ({{$user->xkz_time}})@endif</td>
                        </tr>
                        <tr>
                            <td><span class="title">GSP证书</span> @if($zs_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif  @if(!empty($user->zs_time))
                                    ({{$user->zs_time}})@endif</td>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                        </tr>
                    @elseif($user->user_rank==5)
                        <tr class="first">
                            <td><span class="title">您的委托书已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td><span class="title">营业执照</span> @if($yyzz_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yyzz_time))
                                    ({{$user->yyzz_time}})@endif</td>
                            <td><span class="title">医疗机构执业许可证</span> @if($yljg_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yljg_time))
                                    ({{$user->yljg_time}})@endif</td>
                        </tr>
                        <tr>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        <tr class="first">
                            <td><span class="title">您的资质已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                        </tr>
                    @endif
                </table>


            </div>

            <div class="order fn_clear">
                <div class="title">
                    <h4>最近订单</h4>
                    <p class="title"><a href="{{route('order.index',['status'=>100])}}">待付款 <span
                                    class="num">{{$wait_order}}</span></a> |</p>
                    <p class="title"><a href="{{route('order.index',['status'=>101])}}">待收货 <span
                                    class="num">{{$pay_order}}</span></a>
                    <p class="title" style="float: right"><a class="hover_underline"
                                                             href="{{route('order.index')}}"
                                                             style="font-size: 12px;color: #39a817;line-height: 30px;">更多&gt;&gt;</a>
                    </p>

                </div>
                @if(count($near_order)==0)
                    <div class="tip">
                        <span class="tip_ico"></span>
                        <span>您买的东西太少了，这里空空的，快去挑选合适的商品吧！</span>
                    </div>
                @else
                    <table class="table_order clips">
                        <tr>
                            <th>订单号</th>
                            <th>下单时间</th>
                            <th>订单总金额</th>
                            <th>订单状态</th>
                            <th> 操作</th>
                        </tr>
                        @foreach($near_order as $v)
                            <tr>
                                <td class="nub tb1_td1" data-id='{{$v->order_id}}'><a
                                            href="{{route('order.show',['id'=>$v->order_id])}}">{{$v->order_sn}}</a>
                                </td>
                                <td class="date tb1_td2">{{date('Y-m-d H:i:s',$v->add_time)}}    </td>
                                <td class="score tb1_td4">{{formated_price($v->goods_amount)}}</td>
                                <td class="data tb1_td5">
                                    {!! order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'tip') !!}
                                    &nbsp; &nbsp; <span class="stat" style="color:#39A817;cursor:pointer;" id="ddgz"
                                                        dd-url="{{route('order.ddgz')}}">订单跟踪</span>
                                </td>
                                <td class="result tb1_td6">
                                    {!! order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'handle') !!}
                                    &nbsp; <a href="{{route('order.show',['id'=>$v->order_id])}}" class="f6">查看订单</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div class="collect fn_clear">
                <div class="title">
                    <h4>我的收藏</h4>
                    <p class="title" style="float: right;margin-right: 27px;"><a class="hover_underline"
                                                                                 href="{{route('collect_goods.index')}}"
                                                                                 style="font-size: 12px;color: #39a817;line-height: 30px;">更多&gt;&gt;</a>
                    </p>
                </div>
                @if(count($collection)==0)
                    <div class="tip">
                        <span class="tip_ico"></span>
                        <p>您还没有收藏任何商品，看到感兴趣的商品就果断收藏吧！</p>
                    </div>
                @else
                    <table class="table_order table_collect">
                        <tr>
                            <th>商品名称</th>
                            <th>生产厂家</th>
                            <th>规格</th>
                            <th>价格</th>
                            <th> 操作</th>
                        </tr>
                        @foreach($collection as $v)
                            <tr>
                                <td class="nub tb1_td1"><a
                                            href="{{route('goods.show',['id'=>$v->goods_id])}}">{{str_limit($v->goods_name,14)}}</a>
                                </td>
                                <td class="date tb1_td2">{{str_limit($v->product_name,20)}}</td>
                                <td class="date tb1_td4">{{str_limit($v->ypgg,20)}}</td>
                                <td class="data tb1_td5">@if(1){{formated_price($v->real_price)}}@else
                                        会员可见@endif</td>
                                <td class="result tb1_td6">
                                    <a class="goshopping" @if($v->is_can_see==1) onclick="tocart({{$v->goods_id}})"
                                       @else onclick="tocart1()" @endif>加入购物车</a>
                                    <a href="javascript:if (confirm('您确定要从收藏夹中删除选定的商品吗?')) location.href='{{route('collect_goods.destroy',['id'=>$v->rec_id])}}'"
                                       class="f6">取消收藏</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="groom fn_clear">
                <div class="title">
                    <h4>为您推荐</h4>

                </div>
                <div id="slides" class="visual3 slides">
                    <ul class="slides_container" style="display: block;">
                        <li class="common">
                            <div>
                                @foreach($wntj as $key=>$val)
                                    @if($key<5)
                                        <div class="base">
                                            <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                        src="{{$val->goods_thumb}}"/></a>
                                            <div>
                                                <p alt="{{$val->goods_name}}"
                                                   title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                <p alt="{{$val->shop_price}}"
                                                   title="{{$val->shop_price}}">{{formated_price($val->shop_price)}}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                        @if(count($wntj)>5)
                            <li class="common">
                                <div>
                                    @foreach($wntj as $key=>$val)
                                        @if($key>=5&$key<10)
                                            <div class="base">
                                                <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                            src="{{$val->goods_thumb}}"/></a>
                                                <div>
                                                    <p alt="{{$val->goods_name}}"
                                                       title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                    <p alt="{{$val->shop_price}}"
                                                       title="{{$val->shop_price}}">{{formated_price($val->shop_price)}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        @if(count($wntj)>10)
                            <li class="common">
                                <div>
                                    @foreach($wntj as $key=>$val)
                                        @if($key>=10&$key<15)
                                            <div class="base">
                                                <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                            src="{{$val->goods_thumb}}"/></a>
                                                <div>
                                                    <p alt="{{$val->goods_name}}"
                                                       title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                    <p alt="{{$val->shop_price}}"
                                                       title="{{$val->shop_price}}">{{formated_price($val->shop_price)}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                    <div class="slideControl slideContro_tab">
                        <p class="slide_lBt"><a href="javascript:void(0);" class="prev"></a></p>
                        <p class="slide_rBt"><a href="javascript:void(0);" class="next"></a></p>
                    </div>
                </div>

            </div>
        </div>

        {{--<div class="main_right">--}}
        {{--<h4>公告</h4>--}}
        {{--<ul class="fn_clear">--}}
        {{--@foreach($gg as $v)--}}
        {{--<li><a href="{{route('articleInfo',['id'=>$v->article_id])}}" title="{{$v->title}}">--}}
        {{--<span class="ico"></span>--}}
        {{--<span class="text">{{$v->title}}</span>--}}
        {{--<em>[{{date('m-d',$v->add_time)}}]</em>--}}
        {{--</a></li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</div>--}}
        <div class="content-right">

            <ul class="fn_clear">
                @foreach(get_ads(156) as $v)
                    <li>
                        <a target="_blank" href="{{$v->ad_link}}">
                            <img src="{{$v->ad_code}}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
