@extends('common.index')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new/puyao.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/new/puyao.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/new/change_num.js')}}"></script>
    <style>
        #znq-daohang {
            right: 45px !important;
            bottom: 20px !important;
        }

        .liebiao span {
            font-family: "宋体", serif
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div>
        <div class="goods-box">
            <!--上面的图标-->
            <div class="container-topimg">
                <a href="{{$fl_url}}"><img src="{{get_img_path('images/new/img-title.png')}}"/><span>药品筛选</span></a>
            </div>
            @if(isset($ylfl))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$show_area[$ylfl]}}</span>
                        </div>
                        <a href="{{$fl_url}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 950px;">
                            <ul>
                                @foreach($show_area as $k=>$v)
                                    @if($k!=$ylfl)
                                        <a href="{{$fl_url}}&ylfl={{$k}}">
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
            @if(isset($ylfl1))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$ylfl1_name}}</span>
                        </div>
                        <a href="{{$fl_url1}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" @if(in_array($ylfl,['d','g','h','k'])) style="width: 99%;"
                             @elseif(in_array($ylfl,['i','j']))
                             style="width: 340px;"
                             @else style="width: 800px;" @endif>
                            <ul>
                                @foreach($shaixuan['ylfl']['list'] as $v)
                                    @if($shaixuan['ylfl']['type']==1)
                                        @foreach($v['cate'] as $val)
                                            @foreach($val['cate'] as $value)
                                                @if($value->cat_id!=$ylfl1)
                                                    <a href="{{$fl_url1}}&ylfl1={{$value->cat_id}}">
                                                        <li style="width: 150px;">
                                                            <div>{{str_limit($value->cat_name,20)}}</div>
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        @if($v->cat_id!=$ylfl1)
                                            <a href="{{$fl_url1}}&ylfl1={{$v->cat_id}}">
                                                <li style="width: 150px;">
                                                    <div>{{str_limit($v->cat_name,20)}}</div>
                                                </li>
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($ylfl2))
                <div @if(in_array($ylfl2,[923,753])) class="shaixuan-none" @else class="shaixuan-yongtu"
                     @endif style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$ylfl2_name}}</span>
                        </div>
                        <a href="{{$fl_url2}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 650px;">
                            <ul>
                                @foreach($shaixuan['ylfl']['list'] as $v)
                                    @if($v->cat_id==$ylfl1)
                                        @if($shaixuan['ylfl']['type']==2)
                                            @foreach($v['cate'] as $val)
                                                @if($ylfl1==682)
                                                    @if($val->cat_id!=$ylfl2)
                                                        <a href="{{$fl_url2}}&ylfl2={{$val->cat_id}}">
                                                            <li style="width: 150px;">
                                                                <div>{{str_limit($val->cat_name,20)}}</div>
                                                            </li>
                                                        </a>
                                                    @endif
                                                @else
                                                    @foreach($val['cate'] as $value)
                                                        @if($ylfl1==$v->cat_id)
                                                            <a href="{{$fl_url2}}&ylfl2={{$value->cat_id}}">
                                                                <li style="width: 150px;">
                                                                    <div>{{str_limit($value->cat_name,20)}}
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($v['cate'] as $val)
                                                @if($val->cat_id!=$ylfl2)
                                                    <a href="{{$fl_url2}}&ylfl2={{$val->cat_id}}">
                                                        <li style="width: 150px;">
                                                            <div>{{str_limit($val->cat_name,20)}}</div>
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($xz_arr['jx']))
                <div @if(count($shaixuan['jx'])<=1) class="shaixuan-none" @else class="shaixuan-jixing"
                     @endif style="display: inline-block;z-index: 3;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            剂型：<span class="choose-name">{{$xz_arr['jx']}}</span>
                        </div>
                        <a href="{{str_replace('jx='.$xz_arr['jx'],'',$result->url(1))}}">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($shaixuan['jx'])>8) style="width: 630px"
                             @elseif(count($shaixuan['jx'])==2) style="width: 99%"
                             @else style="width: {{(count($shaixuan['jx'])-1)*80+30}}px" @endif>
                            <ul>
                                @foreach($shaixuan['jx'] as $v)
                                    @if($v!==$xz_arr['jx'])
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
                <div @if(count($shaixuan['ypgg'])<=1) class="shaixuan-none" @else class="shaixuan-guige"
                     @endif style="display: inline-block;z-index: 2;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            规格：<span class="choose-name">{{$ypgg}}</span>
                        </div>
                        <a href="{{str_replace('ypgg='.$ypgg,'',$result->url(1))}}">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($shaixuan['ypgg'])>8) style="width: 630px"
                             @elseif(count($shaixuan['ypgg'])==2) style="width: 99%"
                             @else style="width: {{(count($shaixuan['jx'])-1)*80+30}}px" @endif>
                            @if(count($shaixuan['ypgg'])>1)
                                <ul>
                                    @foreach($shaixuan['ypgg'] as $v)
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
            @if(!empty($product))
                <div class="shaixuan-none" style="display: inline-block;z-index: 2;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            <span class="choose-name">{{str_limit($product,16)}}</span>
                        </div>
                        <a href="{{str_replace('product='.$product,'',$result->url(1))}}">
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
                    @if(count($fl_list)>0)
                        <li class="sx-li1 zhankai">
                            <div class="title">
                                药理分类：
                            </div>
                            @if(count($fl_list)>9)
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
                                @foreach($fl_list as $k=>$v)
                                    @if(isset($ylfl1))
                                        <a href="{{$result->url(1)}}&ylfl2={{$v->cat_id}}">
                                            <li style="width: 150px;">{{str_limit($v->cat_name,14)}}</li>
                                        </a>
                                    @elseif(isset($ylfl))
                                        <a href="{{$result->url(1)}}&ylfl1={{$v->cat_id}}">
                                            <li>{{str_limit($v->cat_name,14)}}</li>
                                        </a>
                                    @else
                                        @if($k=='l')
                                            <a href="/zy">
                                                <li style="width: 150px;">{{$v}}</li>
                                            </a>
                                        @else
                                            <a href="{{$result->url(1)}}&ylfl={{$k}}">
                                                <li style="width: 150px;">{{$v}}</li>
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['jx'])>0&&empty($xz_arr['jx']))
                        <li class="sx-li2 zhankai">
                            <div class="title">
                                剂型：
                            </div>
                            @if(count($shaixuan['jx'])>9)
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
                                @foreach($shaixuan['jx'] as $v)
                                    <a href="{{$result->url(1)}}&jx={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['ypgg'])>0&&empty($ypgg))
                        <li class="sx-li4 zhankai">
                            <div class="title">
                                规格：
                            </div>
                            @if(count($shaixuan['ypgg'])>9)
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
                                @foreach($shaixuan['ypgg'] as $v)
                                    <a href="{{$result->url(1)}}&ypgg={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['sccj'])>0&&empty($product))
                        <li class="sx-li3">
                            <div class="title">
                                厂家首字母：
                            </div>

                            <ul class="shaixuan-ul-2 zimu">
                                @foreach(range('A','Z') as $v)
                                    <li id="{{$v}}" @if(!isset($shaixuan['sccj'][$v])) class="company-none"
                                        @else class="xuanzhe" @endif>
                                        {{$v}}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            @if(count($shaixuan['sccj'])>0&&empty($product))
                @foreach(range('A','Z') as $k=>$v)

                    @if(isset($shaixuan['sccj'][$v])&&count($shaixuan['sccj'][$v])>0)
                        <div class="shaixuan-company-box" id="zm{{$v}}">
                            @foreach($shaixuan['sccj'][$v] as $product)
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
                                        <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                    style="height: 100%;" src="{{$v->goods_thumb}}"/></a>
                                    </div>
                                    <div class="paihang-name">
                                        <div>{{$v->goods_name}}</div>
                                        <div>{{$v->spgg}}</div>
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
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}">{{$v->goods_name}}</a>
                                            <span class="ke">{{$v->spgg}}</span>
                                        </div>
                                        <div class="hover-after">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods_thumb}}"/></a>
                                            <p class="hover-name">{{$v->goods_name}}</p>
                                            <p class="hover-guige">{{$v->spgg}}</p>
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
                                <p style="padding-bottom: 12px;">你可以发布求购意向，合纵医药网会尽快补货！</p>
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
                                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
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
                                                                <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
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
                                                                <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
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
                @if($result->hasPages())
                    {!! $pages_view !!}
                @endif
            </div>
            <!--内容结束-->
        </div>
    </div>
    @if(isset($daohang)&&$daohang==1)
        @include('20170412.daohang')
    @endif
    @include('common.footer')
    <script type="text/javascript">
        $(function () {
            $('.fenlei').hover(function () {
                $('.category-menu').show()
            }, function () {
                $('.category-menu').hide()
            });
            $('.category-menu').hover(function () {
                $('.category-menu').show()
            }, function () {
                $('.category-menu').hide()
            });
            imgscrool('#ban2');
        });

        function last_page(url, lastPage) {
            var currentPage = $('#currentPage').val();
            if (parseInt(currentPage) > parseInt(lastPage)) {
                alert('你要访问的页码不存在!');
                $('#currentPage').val(lastPage);
                return false;
            }
        }
    </script>
@endsection
