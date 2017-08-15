@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/puyao.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/puyao.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div>
        <div class="goods-box">
            <!--上面的图标-->
            <div class="container-topimg">
                <a href="{{route('goods.index')}}"><img
                            src="{{get_img_path('images/new/img-title.png')}}"/><span>药品筛选</span></a>
            </div>
            @if(isset($filter_arr['cat_p2']))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$filter_arr['cat_p1_info']->cat_name}}</span>
                        </div>
                        <a href="{{$result->url(1)}}&cat_id=0"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 700px;">
                            <ul>
                                @foreach($filter_arr['cat_p2'] as $k=>$v)
                                    @if($k!=$cat_id)
                                        <a href="{{$result->url(1)}}&cat_id={{$k}}">
                                            <li style="width: 150px;">
                                                <div>{{$v}}</div>
                                            </li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($filter_arr['cat_p1']))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$filter_arr['cat_p_info']->cat_name}}</span>
                        </div>
                        <a @if(isset($filter_arr['cat_p2'])) href="{{$result->url(1)}}&cat_id={{$filter_arr['cat_p1_info']->cat_id}}"
                           @else href="{{$result->url(1)}}&cat_id=0" @endif><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 700px;">
                            <ul>
                                @foreach($filter_arr['cat_p1'] as $k=>$v)
                                    @if($k!=$cat_id)
                                        <a href="{{$result->url(1)}}&cat_id={{$k}}">
                                            <li style="width: 150px;">
                                                <div>{{$v}}</div>
                                            </li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($filter_arr['cat_p']))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$filter_arr['cat_info']->cat_name}}</span>
                        </div>
                        <a @if(isset($filter_arr['cat_p1'])) href="{{$result->url(1)}}&cat_id={{$filter_arr['cat_p_info']->cat_id}}"
                           @else href="{{$result->url(1)}}&cat_id=0" @endif><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 700px;">
                            <ul>
                                @foreach($filter_arr['cat_p'] as $k=>$v)
                                    @if($k!=$cat_id)
                                        <a href="{{$result->url(1)}}&cat_id={{$k}}">
                                            <li style="width: 150px;">
                                                <div>{{$v}}</div>
                                            </li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($jx))
                <div @if(count($filter_arr['jx'])<=1) class="shaixuan-none" @else class="shaixuan-jixing"
                     @endif style="display: inline-block;z-index: 3;">
                    @if(!isset($cat_id))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            剂型：<span class="choose-name">{{$jx}}</span>
                        </div>
                        <a href="{{$result->url(1)}}&jx=">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($filter_arr['jx'])>8) style="width: 630px"
                             @elseif(count($filter_arr['jx'])==2) style="width: 99%"
                             @else style="width: {{(count($filter_arr['jx'])-1)*80+30}}px" @endif>
                            <ul>
                                @foreach($filter_arr['jx'] as $v)
                                    @if($v!==$jx)
                                        <a href="{{$result->url(1)}}&jx={{$v}}">
                                            <li>{{$v}}</li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($ypgg))
                <div @if(count($filter_arr['ypgg'])<=1) class="shaixuan-none" @else class="shaixuan-guige"
                     @endif style="display: inline-block;z-index: 2;">
                    @if(!isset($cat_id))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            规格：<span class="choose-name">{{$ypgg}}</span>
                        </div>
                        <a href="{{$result->url(1)}}&ypgg=">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($filter_arr['ypgg'])>8) style="width: 630px"
                             @elseif(count($filter_arr['ypgg'])==2) style="width: 99%"
                             @else style="width: {{(count($filter_arr['jx'])-1)*80+30}}px" @endif>
                            @if(count($filter_arr['ypgg'])>1)
                                <ul>
                                    @foreach($filter_arr['ypgg'] as $v)
                                        @if($v!==$ypgg)
                                            <a href="{{$result->url(1)}}&ypgg={{$v}}">
                                                <li>{{$v}}</li>
                                            </a>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
            @endif
        <!--<div class="shaixuan-qingchu">
                清空筛选
            </div>-->
            @if(!empty($product_name))
                <div class="shaixuan-none" style="display: inline-block;z-index: 2;">
                    @if(!isset($cat_id))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            <span class="choose-name">{{str_limit($product_name,16)}}</span>
                        </div>
                        <a href="{{$result->url(1)}}&product_name=">
                            <span class="title-shanchu">×</span>
                        </a>
                    </div>
                </div>
            @endif
        <!--图标-->
            <!--搜索纠正-->
            <!--搜索纠正-->
            <!--分类筛选-->
            <div class="shaixuan">
                <ul class="shaixuan-ul-1">
                    @if(count($filter_arr['cat_c'])>0)
                        <li class="sx-li1 zhankai">
                            <div class="title">
                                药理分类：
                            </div>
                            @if(count($filter_arr['cat_c'])>6)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-2 shaixuan-1">
                                @foreach($filter_arr['cat_c'] as $k=>$v)
                                    <a href="{{$result->url(1)}}&cat_id={{$v->cat_id}}">
                                        <li style="width: 150px;">{{str_limit($v->cat_name,14)}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($filter_arr['jx'])>0&&empty($jx))
                        <li class="sx-li2 zhankai">
                            <div class="title">
                                剂型：
                            </div>
                            @if(count($filter_arr['jx'])>9)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-2 shaixuan-2">
                                @foreach($filter_arr['jx'] as $v)
                                    <a href="{{$result->url(1)}}&jx={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(isset($ypgg)&&count($filter_arr['ypgg'])>0&&empty($ypgg))
                        <li class="sx-li4 zhankai">
                            <div class="title">
                                规格：
                            </div>
                            @if(count($filter_arr['ypgg'])>9)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-3 shaixuan-3">
                                @foreach($filter_arr['ypgg'] as $v)
                                    <a href="{{$result->url(1)}}&ypgg={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($filter_arr['sccj'])>0&&empty($product_name))
                        <li class="sx-li3">
                            <div class="title">
                                厂家首字母：
                            </div>

                            <ul class="shaixuan-ul-2 zimu">
                                @foreach(range('A','Z') as $v)
                                    <li id="{{$v}}" @if(!isset($filter_arr['sccj'][$v])) class="company-none"
                                        @else class="xuanzhe" @endif>
                                        {{$v}}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            @if(count($filter_arr['sccj'])>0&&empty($product))
                @foreach(range('A','Z') as $k=>$v)

                    @if(isset($filter_arr['sccj'][$v])&&count($filter_arr['sccj'][$v])>0)
                        <div class="shaixuan-company-box" id="zm{{$v}}">
                            @foreach($filter_arr['sccj'][$v] as $product)
                                <a href="{{$result->url(1)}}&product={{$product}}">
                                    {{str_limit($product,30)}}
                                </a>
                            @endforeach
                        </div>
                @endif
            @endforeach
        @endif
        <!--分类筛选结束-->

            <!--内容开始-->
            <div class="content">
                <!--销量排行-->
                <div class="content-left">
                    <div class="content-left-title">
                        <div></div>
                        <span>一周销量排行榜</span>
                    </div>
                    @foreach($week_sale as $k=>$v)
                        @if($k<3)
                            <div class="paihang">
                                <div class="paihang-title">
                                    @if($k==0)
                                        <img src="{{get_img_path('images/new/jin.jpg')}}"/>
                                    @elseif($k==1)
                                        <img src="{{get_img_path('images/new/yin.jpg')}}"/>
                                    @elseif($k==2)
                                        <img src="{{get_img_path('images/new/tong.jpg')}}"/>
                                    @endif
                                    {{--<div class="chengjiaoliang">--}}
                                    {{--成交量：<span>{{$v->num}}</span>--}}
                                    {{--</div>--}}
                                    <div class="paihang-img">
                                        <a href="{{route('goods.show',['id'=>$v->goods_id])}}"><img
                                                    style="height: 100%;" src="{{$v->goods_thumb}}"/></a>
                                    </div>
                                    <div class="paihang-name">
                                        <div>{{$v->goods_name}}</div>
                                        <div>{{$v->ypgg}}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="paihang-bottom">
                        <ul>
                            @foreach($week_sale as $k=>$v)
                                @if($k>=3)
                                    <li>
                                        <span>{{$k+1}}</span>
                                        <div class="hover-before">
                                            <a href="{{route('goods.show',['id'=>$v->goods_id])}}">{{$v->goods_name}}</a>
                                            <span class="ke">{{$v->ypgg}}</span>
                                        </div>
                                        <div class="hover-after">
                                            <a href="{{route('goods.show',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods_thumb}}"/></a>
                                            <p class="hover-name">{{$v->goods_name}}</p>
                                            <p class="hover-guige">{{$v->ypgg}}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--销量排行结束-->
                <!--产品开始-->
                @if(count($result)==0)
                    <div class="chanpin_none">
                        <div class="chanpin_none_top">
                            <img src="{{get_img_path('images/none.jpg')}}" style=""/>
                            <div class="text">
                                <p style="padding: 12px 0">抱歉！没有找到@if(!empty($keywords))与<span>“{{$keywords}}
                                        ”</span>@endif相关的药品</p>
                                <p style="padding-bottom: 12px;">你可以发布求购意向，{{trans('common.web_name')}}会尽快补货！</p>
                                <a target="_blank" href="/requirement">发布求购</a>
                            </div>
                        </div>
                        <div id="ban2">
                            <div class="banner">
                                <div class="title">
                                    <img src="{{get_img_path('images/tj_shu.jpg')}}"/>
                                    <span>为您推荐</span>
                                </div>
                                <div class="ul_box">
                                    <ul class="img">
                                        <li>
                                            @foreach($wntj as $k=>$v)
                                                @if($k<5)
                                                    <div class="wntj-cp">
                                                        <div class="wntj-img-box">
                                                            <a target="_blank"
                                                               href="{{route('goods.show',['id'=>$v->goods_id])}}"><img
                                                                        style="width: 100%" src="{{$v->goods_thumb}}"/></a>
                                                        </div>
                                                        <p>{{$v->goods_name}}</p>
                                                        <p class="wntj-cp-jiage"> @if($v->is_can_see==0) 会员可见 @else
                                                                {{formated_price($v->real_price)}}
                                                            @endif</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </li>
                                        @if(count($wntj)>5)
                                            <li>
                                                @foreach($wntj as $k=>$v)
                                                    @if($k>=5&&$k<10)
                                                        <div class="wntj-cp">
                                                            <div class="wntj-img-box">
                                                                <a target="_blank"
                                                                   href="{{route('goods.show',['id'=>$v->goods_id])}}"><img
                                                                            style="width: 100%"
                                                                            src="{{$v->goods_thumb}}"/></a>
                                                            </div>
                                                            <p>{{$v->goods_name}}</p>
                                                            <p class="wntj-cp-jiage"> @if($v->is_can_see==0) 会员可见 @else
                                                                    {{formated_price($v->real_price)}}
                                                                @endif</p>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endif
                                        @if(count($wntj)>10)
                                            <li>
                                                @foreach($wntj as $k=>$v)
                                                    @if($k>=10&&$k<15)
                                                        <div class="wntj-cp">
                                                            <div class="wntj-img-box">
                                                                <a target="_blank"
                                                                   href="{{route('goods.show',['id'=>$v->goods_id])}}"><img
                                                                            style="width: 100%"
                                                                            src="{{$v->goods_thumb}}"/></a>
                                                            </div>
                                                            <p>{{$v->goods_name}}</p>
                                                            <p class="wntj-cp-jiage"> @if($v->is_can_see==0) 会员可见 @else
                                                                    {{formated_price($v->real_price)}}
                                                                @endif</p>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="btn btn_l"></div>
                                <div class="btn btn_r"></div>
                            </div>
                            <ul class="num">
                            </ul>

                        </div>
                    </div>
                @else
                    <div class="content-chanpin">
                        <div class="content-chanpin-title">
                            <ul>
                                <li class="four-text @if(!isset($sort)||(isset($sort)&&$sort=='sort_order')) on @endif">
                                    默认排序
                                </li>
                                <a {!! $result->sort['click_count'] !!}>
                                    <li>
                                        人气
                                        <i></i>
                                    </li>
                                </a>
                                <a {!! $result->sort['sales_volume'] !!}>
                                    <li>
                                        销量
                                        <i></i>
                                    </li>
                                </a>
                                <a {!! $result->sort['shop_price'] !!}>
                                    <li>
                                        价格
                                        <i></i>
                                    </li>
                                </a>
                                <a {!! $result->sort['goods_name'] !!}>
                                    <li>
                                        品名
                                        <i></i>
                                    </li>
                                </a>
                                <a {!! $result->sort['product_name'] !!}>
                                    <li>
                                        厂家
                                        <i></i>
                                    </li>
                                </a>
                                <a href="{{$result->url(1)}}&step=cx">
                                    <li class="four-text @if(isset($step)&&$step=='cx') on @endif">促销产品</li>
                                </a>
                            </ul>
                            <div class="content-chanpin-title-right">
                                <div>共{{$result->total()}}个商品</div>
                                <div><span>{{$result->currentPage()}}</span>/{{$result->lastPage()}}</div>
                                <div>
                                    @if($result->currentPage()>1)
                                        <a href="{{$result->url($result->currentPage()-1)}}"><img
                                                    src="{{get_img_path('images/new/left-1.jpg')}}"/></a>
                                    @else
                                        <img src="{{get_img_path('images/new/left.jpg')}}"/>
                                    @endif
                                </div>
                                <div>
                                    @if($result->currentPage()<$result->lastPage())
                                        <a href="{{$result->nextPageUrl()}}"><img
                                                    src="{{get_img_path('images/new/right.jpg')}}"/></a>
                                    @else
                                        <img src="{{get_img_path('images/new/right-1.jpg')}}"/>
                                    @endif
                                </div>
                                <div>

                                    @if($style=='g')
                                        <i class="fonts-datu"></i>
                                        大图
                                    @else
                                        <a href="{{str_replace('style=l','style=g',$result->url($result->currentPage()))}}"
                                           style="display: block;color: #777;">
                                            <i class="fonts-datu-hui"></i>
                                            大图
                                        </a>
                                    @endif

                                </div>
                                <div>
                                    @if($style=='l')
                                        <i class="fonts-liebiao"></i>
                                        列表
                                    @else
                                        <a href="{{str_replace('style=g','style=l',$result->url($result->currentPage()))}}"
                                           style="display: block;color: #777;">
                                            <i class="fonts-liebiao-hui"></i>
                                            列表
                                        </a>
                                    @endif


                                </div>
                            </div>
                        </div>
                        @if($style=='l')
                            <div class="liebiao">
                                @foreach($result as $k=>$v)
                                    <div class="liebiao-chanpin @if($k==0) firstdiv @endif">
                                        <div class="liebiao-img">
                                            <a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}"/></a>
                                            <div class="tcc-liebiao-img"
                                                 @if($k+1==count($result)) style="border-bottom: 1px solid #e5e5e5" @endif>
                                                <img style="width: 100%;height: 100%" src="{{$v->goods_thumb}}"/>
                                            </div>
                                        </div>
                                        <div class="xiangqing">
                                            <div class="goods_name">
                                                <span><a href="{{$v->goods_url}}">{{$v->goods_name}}</a></span>
                                                @if($v->zyzk>0)
                                                    <span class="youhui">惠</span>
                                                @endif
                                                @if($v->is_zx==1)
                                                    <span class="tejia">买赠</span>
                                                @endif
                                                @if($v->is_cx==1)
                                                    <span class="tejia">
										    特价
                                            <div class="tcc-tejia">
                                                <img src="{{get_img_path('images/new/tcc-tejia.png')}}"/>
                                            </div>
									        </span>
                                                @endif
                                            </div>
                                            <div class="company">
                                                {{str_limit($v->sccj,50)}}
                                            </div>
                                            <div class="guige">
                                                规格：<span>{{str_limit($v->spgg,7)}}</span>
                                                件装量：<span>{{str_limit($v->jzl,8)}}</span>
                                                中包装：<span>{{str_limit($v->zbz,8)}}</span>
                                            </div>
                                            <div class="xiaoqi">
                                                效期：<span>{{$v->xq}}</span>
                                                库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
                                                        缺货@else{{$v->goods_number}}@endif</span>
                                                {{--总销量：<span>{{$v->sales_volume}}</span>--}}
                                            </div>
                                        </div>
                                        <div class="jiage">
                                            @if($v->is_can_see==0) 会员可见 @else
                                                {{formated_price($v->real_price)}}
                                            @endif
                                        </div>
                                        <div class="jiajian">
                                            <div class="jian" onclick="reduce_num({{$v->goods_id}})">
                                                -
                                            </div>
                                            <input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}"
                                                   name="number"
                                                   type="text"
                                                   value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   onblur="changePrice({{$v->goods_id}})"
                                                   data-zbz="{{$v->zbz or 1}}"
                                                   data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}"
                                                   data-xgtype="{{$v->xg_type}}" data-gn="{{$v->goods_number}}"
                                                   data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                            <div class="jia" onclick="add_num({{$v->goods_id}})">
                                                +
                                            </div>
                                            <input type="hidden" value="{{$v->goods_id}}"
                                                   id="goods_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['isYl']}}"
                                                   id="isYl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->goods_number}}"
                                                   id="gn_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->zbz or 1}}"
                                                   id="zbz_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->jzl or 0}}"
                                                   id="jzl_{{$v->goods_id}}"/>
                                        </div>
                                        <div class="jrgwc">
                                            <div class="join"
                                                 @if($v->is_can_see==1) onclick="tocart({{$v->goods_id}})"
                                                 @else onclick="tocart1()" @endif
                                                 id="dsssss_{{$v->goods_id}}">
                                                <img src="{{get_img_path('images/new/gouwuche.jpg')}}"/>
                                                加入购物车
                                            </div>
                                            <div class="shoucang"
                                                 @if($v->is_can_see==1) onclick="tocollect({{$v->goods_id}})"
                                                 @else onclick="tocart1()" @endif>
                                                收藏
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="datu" style="padding-bottom: 5px;">
                                @foreach($result as $k=>$v)
                                    <div class="datu-chanpin @if($k==0||$k%4==0) fist-datu-chanpin @endif">
                                        <div class="datu-chanpin-img">
                                            <a href="{{$v->goods_url}}"><img style="width: 100%;height: 100%"
                                                                             src="{{$v->goods_thumb}}"/></a>
                                            <img @if($v->is_can_see==1) onclick="tocollect({{$v->goods_id}})"
                                                 @else onclick="tocart1()"
                                                 @endif src="{{get_img_path('images/new/datu-shoucang.png')}}"
                                                 class="datu-shoucang"/>
                                            @if($v->is_zx==1)
                                                <div class="datu-tcc">
                                                    {{$v->cxxx}}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="datu-jiage">
                                            @if($v->is_can_see==0)
                                                <span class="dt-jiage">会员可见</span> @else
                                                ￥<span class="dt-jiage">{{$v->real_price}}</span>
                                            @endif
                                            @if($v->zyzk>0)
                                                <span class="hui">惠</span>
                                            @endif
                                            @if($v->is_cx==1)
                                                <span class="manjian">特价</span>
                                            @endif
                                            @if($v->is_zx==1)
                                                <span class="manjian">
								  	        买赠
								        </span>
                                            @endif
                                        </div>
                                        <div class="datu-mingzi">
                                            {{str_limit($v->goods_name,30)}}
                                        </div>
                                        <div class="datu-compamy">
                                            {{str_limit($v->sccj,34)}}
                                        </div>
                                        <div class="datu-guige">
                                            规格：<span>{{$v->spgg}}</span>
                                        </div>
                                        <div class="datu-xiaoqi">
                                            效期：<span>{{$v->xq}}</span>
                                            库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
                                                    缺货@else{{$v->goods_number}}@endif</span>
                                        </div>
                                        <div class="datu-jianzhuang">
                                            件装量：<span class="jianzhuang">{{str_limit($v->jzl,8)}}</span>
                                            中包装：<span>{{str_limit($v->zbz,8)}}</span>
                                        </div>
                                        <div class="jiajian">
                                            <div class="jian" onclick="reduce_num({{$v->goods_id}})">
                                                -
                                            </div>
                                            <input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}"
                                                   name="number"
                                                   type="text"
                                                   value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   onblur="changePrice({{$v->goods_id}})"
                                                   data-zbz="{{$v->zbz or 1}}"
                                                   data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}"
                                                   data-xgtype="{{$v->xg_type}}" data-gn="{{$v->goods_number}}"
                                                   data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>

                                            <div class="jia" onclick="add_num({{$v->goods_id}})">
                                                +
                                            </div>
                                            <input type="hidden" value="{{$v->goods_id}}"
                                                   id="goods_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['isYl']}}"
                                                   id="isYl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->goods_number}}"
                                                   id="gn_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->zbz or 1}}"
                                                   id="zbz_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->jzl or 0}}"
                                                   id="jzl_{{$v->goods_id}}"/>
                                        </div>
                                        <div class="datu-jrgwc"
                                             @if($v->is_can_see==1) onclick="tocart({{$v->goods_id}})"
                                             @else onclick="tocart1()" @endif
                                             id="dsssss_{{$v->goods_id}}">
                                            <img src="{{get_img_path('images/new/datu-gouwuche.png')}}"/>
                                            加入购物车
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif

                    </div>
                @endif
            <!--产品结束-->
                {!! $result->links('layouts.page',['show_form'=>1,'inputs'=>$inputs,'action'=>route('goods.index'),'show_num'=>2]) !!}
            </div>
            <!--内容结束-->
        </div>
    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
