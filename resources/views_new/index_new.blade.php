@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('new/css/lunbo.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('new/js/common.js')}}" type="text/javascript" charset="utf-8"></script>

    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery-color.js')}}" type="text/javascript" charset="utf-8"></script>
    <style>
        .guanggao-zhezhao {
            width: 100%;
            height: 6300px;
            background: rgba(0, 0, 0, 0.43);
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1000000;
        }

        .guanggao {
            position: fixed;
            margin: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 600px;
            height: 460px;
        }

        .guanggao-btn1 {
            margin-left: 105px;
        }

        .guanggao-btn2 {
            margin-left: 70px;
        }

        .qiantai-btn img {
            cursor: pointer;
            margin-top: 15px;
        }

        .huodong-tishi {
            height: 190px;
            position: absolute;
            top: 0;
            margin-left: 1200px;
            z-index: 999;
            cursor: pointer;
            display: inline-block;
        }

        .huodong-tishi-box {
            background: white;
            box-shadow: 0px 3px 16px rgba(0, 0, 0, 0.2);
            display: none;
            position: absolute;
            top: 0;
            width: {{$ad155_width}}px;
            left:-{{$ad155_width}}px;
        }

        .huodong-tishi:hover .huodong-tishi-box {
            display: block;
        }

        .huodong-tishi ul {
            width: 100%;
            display: inline-block;
        }

        .huodong-tishi ul li {
            float: left;
            margin-left: 10px;
            margin-top: 10px;
            display: inline;
        }
        .category-menu{
            display: block !important;
        }
    </style>
@endsection
@section('content')

    <!-- 顶部广告结束 -->

    <!-- 头部开始 -->
    @if($yindao==0)
        @include('common.yindao')
    @endif
    @include('common.header')
    <!-- 头部结束 -->

    <!-- 导航条开始 -->
    @include('common.nav')
    <!------------------------------------------轮播以及产品分类------------------------------------------>
    <!--产品分类开始-->
    <div id="banner">
        <div class="slide_box">
            <div class="banner2">
                <ul class="banner-ctrl" style="width: {{count($ad121)*62}}px">
                    @if($ad121)
                        @foreach($ad121 as $k=>$ad)
                            <li @if($k==0) class="current" @endif>
                                <span class="bg"></span>
                                <div class="ctrl-dot">
                                    <i @if($k==0) class="on" @endif></i>
                                </div>
                                <div class="title-item">
                                    <span class="title-bg"></span>
                                    <div class="title-list">
                                        <p><i></i></p>
                                    </div>
                                </div>
                                <h4>{{str_replace('2017','',$ad->ad_name)}}</h4>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <a class="banner-btn banner-prev" href="javascript:void(0);"></a>
                <a class="banner-btn banner-next" href="javascript:void(0);"></a>
                <div class="banner-pic">
                    @if($ad121)
                        @foreach($ad121 as $k=>$ad)
                            <ul>
                                <li style="background:#{{$ad->ad_bgc}}; @if($k==0) display:list-item; @endif">
                                    <a onClick="_hmt.push(['_trackEvent','首页焦点图1','浏览','{{str_replace('2017','',$ad->ad_name)}}'])"
                                       href="{{$ad->ad_link}}" title="" target="_blank" style="position:relative;">
                                        <img data-src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}"
                                             src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}" height="480"
                                             width="780" alt=" "/>
                                        <!--<span class="addSign">
                                            <img alt="" src="//static.jianke.com/home/front/images/ad_tag.png">
                                        </span>-->
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    @endif

                </div>


            </div>
            <div style="width: 1200px;margin: 0 auto;">
                <div class="slide_right">

                    <ul>
                        @if($ad123)
                            @foreach($ad123 as $k=>$v)
                                @if($k<2)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       style="width: 200px;height: 160px;"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                    <ul class="slide_right-title">
                        <li class="slide_right-title-li1" style="font-weight: bold;">
                            动态
                        </li>
                        <li class="slide_right-title-li2" style="color: rgb(119, 119, 119)">
                            行业
                        </li>
                        <li class="slide_right-title-li3">
                            <a target="_blank" id="dongtai_gd"
                               href="http://www.hezongyy.com/article?id=4">更多&gt;&gt;</a>
                            <a id="cuxiao_gd" target="_blank" style="display: none;"
                               href="http://www.hezongyy.com/article?id=12">更多&gt;&gt;</a>

                        </li>
                    </ul>
                    <ul class="xiabiao">
                        <li class="xiabiao-li1">
                            <hr style="border: 1px solid #3cbb2c;width: 23px;display:block;" class="banner-left-hr">

                        </li>
                        <li class="xiabiao-li2">
                            <hr style="border: 1px solid #3cbb2c;width: 23px;display:none;" class="banner-right-hr">
                        </li>
                    </ul>
                    <div class="news">
                        <div class="news1">
                            <ul>
                                @foreach($art1->article as $k=>$v)
                                    @if($k<4)
                                        <a href="{{route('articleInfo',['id'=>$v->article_id])}}" target="_blank">
                                            <li @if($k==0) style="color: red;" @endif>{{str_limit($v->title,28)}}</li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="news2">
                            <ul>
                                @foreach($art2->article as $k=>$v)
                                    @if($k<4)
                                        <a style="display: block" @if(!empty($v->keywords)) href="{{$v->keywords}}"
                                           @else href="{{route('articleInfo',['id'=>$v->article_id])}}"
                                           @endif target="_blank">
                                            <li @if($k==0) style="color: red;" @endif>{{str_limit($v->title,28)}}</li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>


                </div>
                <div class="huodong-tishi">
                    <a target="_blank" href="/cxhd/cxzq"><img src="{{get_img_path('images/qiantai_04.png')}}"/></a>
                    <div class="huodong-tishi-box">
                        <ul>
                            @foreach($ad155 as $v)
                                <li>
                                    <a target="_blank" href="/cxhd/cxzq#{{$v->ad_link}}" class="zy-{{$v->ad_link}}">
                                        <img src="{{$v->ad_code}}"/>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!--产品分类结束-->
        <!------------------------------------------轮播以及产品分类结束------------------------------------------>


        <!------------------------------------------每日精选开始------------------------------------------>
        <!------------------------------------------每日精选开始------------------------------------------>
        <input type="hidden" id="daojs" value="{{collect($ad124->first())->get('end_time')-time()}}"/>
        <div class="meiri" id="demo1">
            <div class="meiri-box">
                <div class="timeout">
                    <div id="remainTime"></div>
                </div>
                <div class="meiri-shangpin" style="position: relative;">
                    @if($ad124)
                        @foreach($ad124 as $k=>$v)
                            @if($k<2)
                                @if($k==0)
                                    <a target="_blank" href="{{$v->ad_link}}"
                                       style="position: absolute;top:10px;left:10px;overflow: hidden;height: 450px;">
                                        <img src="{{$v->ad_code}}"
                                             style="transition: all .5s linear;width: 295px;height: 450px;"/>
                                    </a>
                                @else
                                    <a target="_blank" href="{{$v->ad_link}}"
                                       style="float:right;margin-right: 10px;margin-top: 10px;overflow: hidden;height: 450px;">
                                        <img src="{{$v->ad_code}}"
                                             style="transition: all .5s linear;width: 295px;height: 450px;"/>
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <ul style="position: relative;">
                        @if($ad125)
                            @foreach($ad125 as $k=>$v)
                                @if($k<4)
                                    <li @if($k<2) class="topimg1" @else class="topimg2" @endif>
                                        <a href="{{$v->ad_link}}" target="_blank">
                                            <img src="{{$v->ad_code}}" style="width: 280px;height: 220px;"/>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>
            </div>
        </div>

        <!------------------------------------------每日精选结束------------------------------------------>


        <!------------------------------------------每日精选结束------------------------------------------>
        <div class="tuijian" id="demo2">
            <div class="tuijian-box">
                <div>
                    <img src="{{path('new/images/tuijian.png')}}"/>
                    <div class="picScroll-left">
                        <div class="hd">
                            <a class="prev" href="javascript:void(0)"><img
                                        src="{{path('new/images/button-left_12.png')}}"/></a>
                            <a class="next" href="javascript:void(0)"><img
                                        src="{{path('new/images/button-right_12.png')}}"/></a>
                        </div>
                        <div class="bd" style="margin-top: -20px;">
                            <ul class="picList">
                                @if($wntj)
                                    @foreach($wntj as $k=>$v)
                                        <li>
                                            <div class="pic1">
                                                <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank">
                                                    <img src="{{$v->goods_thumb}}"/>
                                                </a>
                                            </div>
                                            <div class="title">
                                                <p class="title-first-one">{{$v->goods_name}}</p>
                                                <p class="title-first-two">{{$v->spgg}}</p>
                                                <p class="title-first-second">{{$v->sccj}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--以下是新品上市，产品推荐，用无序列表-->
        <div id="container">
            <div class="container-box">
                <!--新品-->
                <div class="xinpin" id="demo3">

                    <img src="{{path('new/images/xinpin.png')}}" style="margin-top: 50px;"/>


                    <div class="wrapper1">
                        <div id="focus" class="focus">
                            <ul>
                                @if($ad126)
                                    @foreach($ad126 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>

                    <ul class="Allul">
                        @if($ad127)
                            @foreach($ad127 as $k=>$v)
                                @if($k<6)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                @if($ad128)
                    @foreach($ad128 as $k=>$v)
                        @if($k<3)
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                            </a>
                        @endif
                    @endforeach
                @endif
            <!--新品-->

                <!--产品推荐-->
                <div class="chanpintuijian" id="demo4" style="height:610px;">
                    <img src="{{path('new/images/chanpintuijian.png')}}" style="margin-top: 20px;"/>
                    <div class="wrapper1">
                        <div id="focus1" class="focus">
                            <ul style="height: 400px;">
                                @if($ad129)
                                    @foreach($ad129 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>

                    <ul class="Allul">
                        @if($ad130)
                            @foreach($ad130 as $k=>$v)
                                @if($k<6)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>
                @if($ad131)
                    @foreach($ad131 as $k=>$v)
                        @if($k<3)
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                            </a>
                        @endif
                    @endforeach
                @endif
            <!--产品推荐-->
                <!--当前热销-->
                <div class="chanpintuijian" id="demo5" style="height:610px;">
                    <img src="{{path('new/images/dangqianrexiao_03.png')}}" style="margin-top: 20px;"/>
                    <div class="wrapper1">
                        <div id="focus2" class="focus">
                            <ul style="height: 400px;">
                                @if($ad133)
                                    @foreach($ad133 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>

                    <ul class="Allul">
                        @if($ad134)
                            @foreach($ad134 as $k=>$v)
                                @if($k<6)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>
                <!--当前热销-->
                @if($ad135)
                    @foreach($ad135 as $k=>$v)
                        @if($k<3)
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                            </a>
                        @endif
                    @endforeach
                @endif

            <!--家用保健-->
                <div class="jiayongbaojian" id="demo6" style="height: 610px;">
                    <img src="{{path('new/images/family.png')}}" style="margin-top: 20px;"/>
                    <div class="wrapper2">
                        <div id="focus3" class="focus1">
                            <ul style="height: 400px;">
                                @if($ad137)
                                    @foreach($ad137 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                        <div class="fenleiid">
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>375])}}" class="fenleili1">
                                    日常护理系列
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>376])}}" class="fenleili2">
                                    女性营养系列
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>378])}}" class="fenleili1">
                                    中老年营养系列
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>379])}}" class="fenleili2">
                                    青少年营养系列
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>380])}}" class="fenleili1">
                                    免疫调节类
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.index',['phaid'=>389])}}" class="fenleili2">
                                    奶粉类
                                </a>
                            </li>
                        </div>
                    </div>

                    <ul class="Allul jiayong">
                        @if($ad138)
                            @foreach($ad138 as $k=>$v)
                                @if($k<6)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>
                @if($ad136)
                    @foreach($ad136 as $k=>$v)
                        @if($k<3)
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                            </a>
                        @endif
                    @endforeach
                @endif
            <!--家用保健-->

                <!--中药饮片-->
                <div class="chanpintuijian" id="demo7" style="height:610px;">
                    <img src="{{path('new/images/zhongyao.png')}}" style="margin-top: 20px;"/>
                    <div class="wrapper2">
                        <div id="focus4" class="focus1">
                            <ul style="height: 400px;">
                                @if($ad140)
                                    @foreach($ad140 as $k=>$v)
                                        <li>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                        <div class="fenleiid">
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>448])}}" class="fenleili1">
                                    普通配方饮片
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>449])}}" class="fenleili2">
                                    贵细摆盘饮片
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>474])}}" class="fenleili1">
                                    定型包装饮片
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>484])}}" class="fenleili2">
                                    中药粉剂系列
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>486])}}" class="fenleili1">
                                    精致礼盒饮片
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="{{route('category.zyyp',['phaid'=>488])}}" class="fenleili2">
                                    畅销热卖专区
                                </a>
                            </li>
                        </div>
                    </div>

                    <ul class="Allul">
                        @if($ad139)
                            @foreach($ad139 as $k=>$v)
                                @if($k<6)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                </div>
                @if($ad141)
                    @foreach($ad141 as $k=>$v)
                        @if($k<3)
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                            </a>
                    @endif
                @endforeach
            @endif
            <!--中药饮片-->

                <!--推荐商家-->
                <div class="changjia" id="demo8">
                    <div style="position: relative">
                        <img src="{{path('new/images/changjia.png')}}" style="margin-top: 20px;"/>
                        <a target="_blank" href="/ppzq"
                           style="position: absolute;width: 100px;height: 30px;top: 30px;right: 47px;background: url('{{path('new/images/images/x.png')}}');"></a>
                    </div>
                    <div class="changjiaxinxi" style="width: 1200px;height:631px;margin-top:10px;background: white;">
                        <div class="main-page">
                            <div class="left">
                                <div class="nav-back"></div>
                                <div class="nav">
                                    @if($ad142)
                                        @foreach($ad142 as $k=>$v)
                                            <div @if($k==0)class="on"@endif>
                                                <a href="{{$v->ad_link}}" target="_blank"><img
                                                            src="{{$v->ad_code}}"/></a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="right">
                                <div class="content">
                                    @if($ad142)
                                        @foreach($ad142 as $key=>$cj)
                                            <div>
                                                <ul class="changjia-img">
                                                    @if($cj->goods_list)
                                                        @foreach($cj->goods_list as $k=>$v)
                                                            <li>
                                                                <a target="_blank"
                                                                   href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                                            style="width: 200px;height: 200px;"
                                                                            src="{{$v->goods_thumb}}"/></a>
                                                                <div class="changjia-wenzi">
                                                                    <p>
                                                                    <span style="color: red;">【{{str_replace('2017','',$cj->ad_name)}}
                                                                        】</span>{{$v->goods_name}}
                                                                    </p>
                                                                    <p>{{$v->spgg}}</p>
                                                                    <p>{{$v->sccj}}</p>
                                                                </div>

                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>


                    </div>

                </div>
                <!--推荐商家-->


                <!--以下是新品上市，产品推荐，用无序列表结束-->
                <!--<hr style="width:99.9%;position: absolute;top: 5805px;border: 1px solid #e5e5e5;"/>-->
                <!--右侧边栏开始-->

                <!--右侧边栏结束-->
                <!-- 浮动导航 -->

                <!--楼层提示-->

                <div id="fixedNavBar">

                    <ul>

                        <li style="background-color: #3dbb2b">
                            <a href="#demo0">
                                <p style="line-height: 28px;">
                                    导航
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo1">
                                <p>
                                    每周精选
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo2">
                                <p>
                                    为您推荐
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo3">
                                <p>
                                    新品上架
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo4">
                                <p>
                                    产品推荐
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo5">
                                <p>
                                    当季热销
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo6">
                                <p>
                                    家用保健
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo7">
                                <p>
                                    中药饮片
                                </p>
                            </a>

                        </li>
                        <li>
                            <a href="#demo8">
                                <p>
                                    厂家推荐
                                </p>
                            </a>

                        </li>

                    </ul>
                </div>


            </div>
        </div>
    @if($yindao==1&&$ad27)
        <!-- 弹出层开始 -->
            <div class="zzsc" style="display: block;z-index: 999999;">
                <div class="content_tj"><a href="{{$ad27->ad_link}}" target="_blank"><img
                                src="{{get_img_path('data/afficheimg/'.$ad27->ad_code)}}" class="ad"></a>
                    <span class="close"><img src="{{path('/images/close.png')}}" alt=""></span>
                </div>
            </div>

            <div class="content_mark" style="display: block;z-index: 999990"></div>
        @elseif(!$ad27&&auth()->check()&&isset($sjtj)&&$sjtj_type==1)
            <div class="guanggao-zhezhao">
                <div class="guanggao">
                    <a id="qukankan" url="{{$sjtj->ad_link}}"><img
                                src="{{get_img_path('data/afficheimg/'.$sjtj->ad_code)}}"/></a>
                    <div class="qiantai-btn">
                        <img src="{{get_img_path('images/btn1.png')}}" class="guanggao-btn1" url="{{$sjtj->ad_link}}"/>
                        <img src="{{get_img_path('images/btn2.png')}}" class="guanggao-btn2"/>
                    </div>
                </div>
            </div>
        @endif

    <!-- app扫描开始 -->
        @if(isset($ad147))
            @foreach($ad147 as $k=>$v)
                @if($k==0)
                    <div class="saoma" style="left: 0px;bottom: 35px">
                        <div class="saoma-box">
                            <span class="saoma-close"
                                  style="top: 9px;right: -3px;background-image: url('{{path('new/images/x.png')}}')"
                                  onclick="$('.saoma').hide()"></span>
                            <a @if(!empty($v->ad_link)) target="_blank"
                               href="{{$v->ad_link}}" @else href="javascript:;" @endif>
                                <img src="{{$v->ad_code}}" alt=""></a>
                        </div>

                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <!-- app扫描结束 -->
    <!-- 弹出层结束 -->
    @include('common.footer')
    @include('common.fixed_search')


    <script src="{{path('new/js/new-lunbo.js')}}" type="text/javascript" charset="utf-8"></script>
    <!--[if lte IE 8]>
    <script src="{{path('new/js/ieBetter.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        $(function () {
            /*导航跳转效果插件*/
            $('#fixedNavBar,.qudingbu,#lvjing').singlePageNav({
                offset: 0
            });
            var _left = ($(window).width() - 1200) / 2 - 40
            $('#fixedNavBar').css('left', _left);
            $(window).scroll(function () {
                var cy = 40;
                var top1 = $('#demo1').offset().top - cy * 2;
                var top2 = $('#demo2').offset().top - cy * 2;
                var top3 = $('#demo3').offset().top - cy * 3;
                var top4 = $('#demo4').offset().top - cy * 4;
                var top5 = $('#demo5').offset().top - cy * 5;
                var top6 = $('#demo6').offset().top - cy * 6;
                var top7 = $('#demo7').offset().top - cy * 7;
                var top8 = $('#demo8').offset().top - cy * 8;
                var top9 = parseFloat(top8) + parseFloat($('#demo8').css('height'));
                // 获得窗口滚动上去的距离
                var ling = $('#fixedNavBar').offset().top;
                // 在标题栏显示滚动的距离
                //document.title = ling;
                // 如果滚动距离大于1534的时候让滚动框出来
                if (ling >= top1 && ling < top9) {
                    if (_left < 20) {
                        _left = 20
                    }
                    var hehe = $('#fixedNavBar ul li ');
                    $('#fixedNavBar ul').show();
                    if (ling >= top1 && ling < top2) {
                        hehe[1].style.background = '#3dbb2b';


                    } else {
                        hehe[1].style.background = '#666666';
                    }
                    if (ling >= top2 && ling < top3) {
                        hehe[2].style.background = '#3dbb2b';
                    } else {
                        hehe[2].style.background = '#666666'
                    }
                    if (ling >= top3 && ling < top4) {
                        hehe[3].style.background = '#3dbb2b';
                    } else {
                        hehe[3].style.background = '#666666'
                    }
                    if (ling >= top4 && ling < top5) {
                        hehe[4].style.background = '#3dbb2b';
                    } else {
                        hehe[4].style.background = '#666666';
                    }
                    if (ling >= top5 && ling < top6) {
                        hehe[5].style.background = '#3dbb2b';
                    } else {
                        hehe[5].style.background = '#666666';
                    }
                    if (ling >= top6 && ling < top7) {
                        hehe[6].style.background = '#3dbb2b';
                    } else {
                        hehe[6].style.background = '#666666';
                    }
                    if (ling >= top7 && ling < top8) {
                        hehe[7].style.background = '#3dbb2b';
                    } else {
                        hehe[7].style.background = '#666666';
                    }

                    if (ling >= top8 && ling < top9) {
                        hehe[8].style.background = '#3dbb2b';
                    } else {
                        hehe[8].style.background = '#666666';
                    }
                } else {
                    $('#fixedNavBar ul').hide();
                }

            })

            $('.slide_right-title-li1').hover(function () {
                $('.news1 ul').css('display', 'block');
                $('.news2 ul').css('display', 'none');
                $('.banner-left-hr').css('display', 'block');
                $('.banner-right-hr').css('display', 'none');
                $('.slide_right-title-li1').css('color', '#333333');
                $('.slide_right-title-li1').css('font-weight', 'bold');
                $('.slide_right-title-li2').css('color', '#777777');
                $('.slide_right-title-li2').css('font-weight', 'normal');
                $('#cuxiao_gd').hide();
                $('#dongtai_gd').show();
            });
            $('.slide_right-title-li2').hover(function () {
                $('.news2 ul').css('display', 'block');
                $('.news1 ul').css('display', 'none');
                $('.banner-left-hr').css('display', 'none');
                $('.banner-right-hr').css('display', 'block');
                $('.slide_right-title-li2').css('color', '#333333');
                $('.slide_right-title-li2').css('font-weight', 'bold');
                $('.slide_right-title-li1').css('color', '#777777');
                $('.slide_right-title-li1').css('font-weight', 'normal');
                $('#dongtai_gd').hide();
                $('#cuxiao_gd').show();
            });


            $(".main-page .nav div").mouseenter(function () {
                var $this = $(this);
                var index = $this.index();
            }).mouseleave(function () {
                var $this = $(this);
                var index = $this.index();
            }).hover(function () {
                var $this = $(this);
                var index = $this.index();
                var l = -(index * 930);
                $(".main-page .nav div").removeClass("on");
                $(".main-page .nav div").eq(index).addClass("on");
                $(".main-page .content div:eq(0)").stop().animate({"margin-top": l}, 500);
            });
            jQuery(".picScroll-left").slide({
                titCell: ".hd ul",
                mainCell: ".bd ul",
                autoPage: true,
                effect: "left",
                autoPlay: true,
                vis: 5,
                trigger: "click"
            });
            $('.guanggao-btn1').click(function () {
                var url = $(this).attr('url');
                var sjtj_type = '{{$sjtj_type or 1}}'
                $.ajax({
                    url: '/user/sjtj',
                    type: 'get',
                    data: {type: 1},
                    success: function () {
                        //window.open(url);
                    }
                });
                window.open(url);
            });
            $('#qukankan').click(function () {
                var url = $(this).attr('url');
                var sjtj_type = '{{$sjtj_type or 1}}'
                $.ajax({
                    url: '/user/sjtj',
                    type: 'get',
                    data: {type: 1},
                    success: function () {
                        //window.open(url);
                    }
                });
                window.open(url);
            });
            $('.guanggao-btn2').click(function () {
                var sjtj_type = '{{$sjtj_type or 1}}'
                $.ajax({
                    url: '/user/sjtj',
                    type: 'get',
                    data: {type: 0},
                    success: function () {
                        //$('.guanggao-zhezhao').hide()
                    }
                });
                $('.guanggao-zhezhao').hide()
            });
            setTimeout(function () {
                $(".guanggao-zhezhao").hide();
                $(".guanggao").hide();
            }, 10000);
        })
    </script>
@endsection

