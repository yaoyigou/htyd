@extends('layouts.app')
@section('css')
    <link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index/lunbo.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index/main.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/common/fixed_search.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/index/index.js')}}"></script>
    <style>
        .category-menu {
            display: block;
        }
    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="slide_box">
        <div class="banner2">
            <ul class="banner-ctrl" style="width: {{count($ad121)*62}}px">
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
            </ul>
            <a class="banner-btn banner-prev" href="javascript:void(0);"></a>
            <a class="banner-btn banner-next" href="javascript:void(0);"></a>
            <div class="banner-pic">
                @foreach($ad121 as $k=>$ad)
                    <ul>
                        <li style="background:#{{$ad->ad_bgc}}; @if($k==0) display:list-item; @endif">
                            <a onClick="_hmt.push(['_trackEvent','首页焦点图1','浏览','{{str_replace('2017','',$ad->ad_name)}}'])"
                               href="{{$ad->ad_link}}" title="" target="_blank" style="position:relative;">
                                <img data-src="{{$ad->ad_code}}"
                                     src="{{$ad->ad_code}}" height="480"
                                     width="780" alt=" "/>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>

        </div>
        <div style="width: 1200px;margin: 0 auto;">
            <div class="slide_right">
                @foreach($ad123 as $k=>$v)
                    @if($k<2)
                        <a href="{{$v->ad_link}}" @if($k==0) class="first_a" @endif>
                            <img src="{{$v->ad_code}}"/>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div id="container">
        <div class="container-box">
            @foreach($floors as $k=>$v)
                <div class="chanpintuijian" id="demo{{$k}}">
                    <div class="content_title">
                        <div class="shaixuan">
                            @foreach($v->child as $v1)
                                <li @if($loop->first) class="on" @endif>{{$v1->cat_name}}@if(!$loop->last)<img
                                            src="{{path('images/index/shu.jpg')}}"/>@endif</li>
                            @endforeach
                        </div>
                        <img src="{{path('images/index/title_left.jpg')}}"/><span>{{$k+1}}F</span><img
                                src="{{path('images/index/title_right.jpg')}}"/><span>{{$v->cat_name}}</span>
                    </div>
                    <div class="wrapper1">
                        <div id="focus{{$k+1}}" class="focus">
                            <ul style="height: 400px;">
                                @foreach($v->ad1 as $v1)
                                    <li>
                                        <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="img_box">
                            <ul>
                                @foreach($v->ad2 as $v1)
                                    <li>
                                        <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <ul class="Allul">
                        @foreach($v->ad3 as $v1)
                            <li>
                                <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                            </li>
                        @endforeach
                    </ul>
                    @if(count($v->ad4)>0)
                        <div class="content_bot">
                            @foreach($v->ad4 as $v1)
                                <a href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <!-- app扫描结束 -->
        <!-- 弹出层结束 -->
        <!--尾部-->
        @include('layouts.footer')
    </div>
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
@section('js')
    <script type="text/javascript" src="{{path('js/index/new-lunbo.js')}}"></script>
@endsection