@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/goods_detail.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>
<script type="text/javascript" src="{{path('js/goods_list.js')}}"></script>
<script type="text/javascript" src="{{path('js/jquery.jqzoom.js')}}"></script>
<script type="text/javascript" src="{{path('js/goods_detail.js')}}"></script>
<script type="text/javascript" src="{{path('js/jquery.mousewheel.js')}}"></script>
<script type="text/javascript" src="{{path('js/jump.js')}}"></script>
@endpush
@push('footer')
<script type="text/javascript">
    $(function () {

        var bars = '.jspHorizontalBar, .jspVerticalBar';

        $('.scroll-pane').bind('jsp-initialised', function (event, isScrollable) {

            //hide the scroll bar on first load
            $(this).find(bars).hide();

        }).jScrollPane().hover(
            //hide show scrollbar
            function () {
                $(this).find(bars).stop().fadeTo('fast', 0.9);
            },
            function () {
                $(this).find(bars).stop().fadeTo('fast', 0);
            }
        );
        $('.li_3').click(function () {
            $('.ul_list').hide();
        })
    });
</script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="main fn_clear" style="margin-bottom: 5px;">
        <div class="top">@include('layouts.ur_here')</div>
        <div class="content">
            <form action="javascript:;" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
                <!-- 大图begin -->
                <div class="left">
                    <div id="preview" class="spec-preview">
                        <span class="jqzoom"><img jqimg="{{$info->goods_img}}" src="{{$info->goods_img}}"/></span>
                    </div>
                    <!-- 大图end -->
                    <!-- 缩略图begin -->
                    <div class="spec-scroll fn_clear"><a class="prev2"></a> <a class="next2"></a>
                        <div class="items">
                            <ul>
                                @foreach($img as $v)
                                    <li><img bimg="{{get_img_path($v->img_url)}}" src="{{get_img_path($v->thumb_url)}}"
                                             onmousemove="preview(this);"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- 缩略图end -->
                    <div class="share">

                        <div class="bdsharebuttonbox">
                            <a href="#" class="bds_more" data-cmd="more">分享到：</a>
                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                            <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">
                            </a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        </div>

                        <div class="right_box">
                            <span class="ico"></span><a
                                    @if($info->is_can_see==1) href="javascript:tocart({{$info->goods_id}})"
                                    @else href="javascript:tocart1()" @endif>收藏商品</a>
                        </div>
                    </div>

                </div>

                <div class="mid">
                    <div class="mid_top">
                        <h3>&nbsp;{{$info->goods_name}}</h3>
                        @if($info->is_cx==1||$info->is_zx==1||(in_array($info->goods_id,[714,18059])))

                            @if($info->cxxx)
                                <p>{{$info->cxxx}}</p>
                            @endif

                        @endif
                    </div>

                    <table>
                        <tr>
                            @if($info->is_can_see==1)
                                @if($info->is_cx==1)
                                    <td class="td1">促 销 价：</td>
                                @else
                                    <td class="td1">会 员 价：</td>
                                @endif
                                <td class="td2 price"><span class="prices">{{$info->real_price_format}}</span></td>
                            @else
                                @if($info->is_cx==1)
                                    <td class="td1">促 销 价：</td>
                                @else
                                    <td class="td1">会 员 价：</td>
                                @endif
                                <td class="td2 price"><span class="prices">{{$info->real_price_format}}</span></td>
                            @endif
                            <td class="td1">建议零售价：</td>
                            <td class="td2 price">{{formated_price($info->market_price)}}</td>
                        </tr>


                        <tr>
                            <td class="td1">生产厂家：</td>
                            <td class="td2">{{$info->sccj}} </td>
                            @if($info->ls_gg!=0)
                                <td class="td1">最低购买量：</td>
                                <td class="td2">{{$info->ls_gg}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">包装单位：</td>
                            <td class="td2">{{$info->dw}} </td>
                            @if($info->ls_ggg!=0&&$info->is_cx==1)
                                <td class="td1">最高购买量：</td>
                                <td class="td2">{{$info->ls_ggg}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">药品规格：</td>
                            <td class="td2">{{$info->spgg}} </td>
                            @if($info->xq)
                                <td class="td1">效期：</td>
                                <td class="td2"
                                    @if($info->is_xq_red==1) style="color: #e70000" @endif>{{$info->xq}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">批准文号：</td>
                            <td class="td2">{{$info->gyzz}} </td>
                            <td class="td1"></td>
                            <td class="td2"></td>
                        </tr>

                        <tr>
                            <td class="td1">@if($info->is_zyyp)产　　地@else件 装 量@endif：</td>
                            <td class="td2">{{$info->jzl}} </td>
                            @if(!empty($info->zbz))
                                <td class="td1">中 包 装：</td>
                                <td class="td2">{{$info->zbz}}<input type="hidden" value="{{$info->zbz}}" id="zbz"
                                                                     name="zbz"/></td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>


                    </table>

                    <div class="num">
                        <span class="title">数　　　量：</span>
                        <a href="javascript:void(0)" class="reduce jianOne"
                           onclick="reduce_num({{$info->goods_id}})">-</a>
                        <input type="text" name="number" onblur="changePrice({{$info->goods_id}})"
                               value="@if($info->ls_gg>0){{$info->ls_gg}}@else{{$info->zbz or 1}}@endif"
                               id="J_dgoods_num_{{$info->goods_id}}" class="num_txt"
                               style="border:1px solid #a7a6ac; width:60px; height:32px; border-right:0; border-left:0; text-align:center; float:left;"
                               data-zbz="{{$info->zbz or 1}}" data-lsgg="{{$info->ls_gg}}"
                               data-lsggg="{{$info->ls_ggg}}" data-xgtype="{{$info->xg_type}}"
                               data-gn="{{$info->goods_number}}" data-xgtypeflag="{{$info->isXg}}">
                        <a href="javascript:void(0)" class="add addOne" onclick="add_num({{$info->goods_id}})">+</a>
                        <span class="tip">
                        @if($info->goods_number>800)库存充裕@elseif($info->goods_number==0)暂时缺货@else库存
                            &nbsp;{{$info->goods_number}}&nbsp;{{$info->dw}}@endif
				        </span>
                        <input type="hidden" value="{{$info->goods_id}}" id="goods_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->ls_gg}}" id="lsgg_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->is_xg}}" id="yl_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->xg_num}}" id="isYl_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->goods_number}}" id="gn_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->zbz or 1}}" id="zbz_{{$info->goods_id}}"/>
                        <input type="hidden" value="{{$info->jzl or 0}}" id="jzl_{{$info->goods_id}}"/>
                    </div>
                    <div class="add_cart @if($info->is_can_see==0) no_shopping @endif">
                        @if($info->xzgm==1&&$info->is_can_buy==0)
                            <div class="add_btn"
                                 style='width: 280px;height: 110px;font-size: 18px;float: left;text-align: center;line-height: 110px;color: red;'>
                                控销商品，如需购买请联系客服！
                            </div>
                        @else
                            <a href="@if($info->is_can_see==0) javascript:tocart1() @else javascript:tocart({{$info->goods_id}}) @endif"
                               class="add_btn">
                                <span class="ico"></span> 加入购物车</a>
                        @endif
                        <div class="add_weixin">
                            <img src="../images/detail_09.png" alt=""/>
                            <p class="saosao">扫一扫</p>
                            <p>进入官方微信</p>
                        </div>
                    </div>
                    <div class="payment">
                        <p>
                            <span class="way">支付方式</span>
                            <span class="box"><span class="ico ico1"></span><a
                                        href="{{route('article.show',['id'=>91])}}">在线支付</a></span>
                            <span class="box"><span class="ico ico2"></span><a
                                        href="{{route('article.show',['id'=>49])}}">银行汇款</a></span>
                            <a href="{{route('article.show',['id'=>5])}}" class="txt">如何购买？ </a>
                        </p>
                    </div>

                </div>
                <div class="right">
                    <img src="../images/detail66.png" alt=""/>
                </div>
            </form>
        </div>
        <div class="bottom">
            <div class="left_list">
                <div class="list_top">
                    <h3>推荐厂家</h3>
                    <ul>
                        @foreach(get_ads(34) as $k=>$v)

                            <li>
                                <a href="{{$v->ad_link}}" target="_blank">
                                    <img src="{{$v->ad_code}}" alt=""/>
                                </a>
                            </li>

                        @endforeach
                    </ul>

                </div>
                <div class="list_next">
                    <h3>一周销量排行榜</h3>
                    <ul>
                        @foreach($weekSales as $k=>$v)
                            <li @if($k==0)class="first"@endif>
                                <a href="{{$v->goods_url}}" class="list">
                                    <span class="com_num red">{{$k+1}}</span>
                                    <span class="name" alt="{{$v->goods_name}}"
                                          title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

                                    <span class="norms" alt="" title="{{$v->ypgg}}">{{str_limit($v->ypgg,6)}}</span>

                                </a>
                                <span class="span_hide">
						<span class="com_num red">{{$k+1}}</span>
						<a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}"
                                                         title="{{$v->goods_name}}"/></a>
						<span class="title" alt="{{$v->goods_name}}"
                              title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

						<span class="norms" alt="{{$v->ypgg}}" title="{{$v->ypgg}}">{{str_limit($v->ypgg,6)}}</span>

					</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="right_list" style="border: none">
                <div style="border: 1px solid #ddd;">
                    <div class="title_list">
                        <ul>
                            <li class="li_1 on">商品详情</li>
                            <li class="li_2">药品说明书</li>
                            <li class="li_3">售后保障</li>
                        </ul>
                        <div class="f_right">
                            <!--<span class="text">下载客户端，特价随时抢 </span>
                            <img src="./images/detail_64.png" alt=""/>
                            <span class="ico"></span>-->
                        </div>


                    </div>
                    <ul class="ul_list ul_1" style="display: block;">
                        {{--<li>产品参数：</li>--}}
                        {{--<li>品牌名称：{{$info->brand->brand_name or ''}}</li>--}}


                        <li>生产厂家：{{$info->sccj}}</li>
                        <li>包装单位：{{$info->dw}}</li>
                        <li>药品规格：{{$info->spgg}}</li>
                        <li>批准文号：{{$info->gyzz}}</li>
                        <li>@if($info->is_zyyp)产　　地@else件 装 量@endif：{{$info->jzl}}</li>

                        <li>{!! $info->goods_desc !!}</li>
                    </ul>
                    <ul class="ul_list ul_2">
                        <li>{!! $info->goods_sms !!}</li>
                    </ul>
                    <ul class="content_7" style="display: none;">
                        <div class="scroll-pane">
                            <img src="{{get_img_path('images/shouhou-1.jpg')}}"/>
                            <img src="{{get_img_path('images/shouhou-2.jpg')}}"/>
                            <img src="{{get_img_path('images/shouhou-3.jpg')}}"/>
                        </div>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
