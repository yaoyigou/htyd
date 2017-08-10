@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<style type="text/css">
    .block_1 {
        height: auto;
        width: 1200px;
        margin: 30px auto;
        box-shadow: 0 0 10px rgb(179, 177, 178);
        border: 1px solid #e5e5e5;
        overflow: hidden;
        line-height: 30px;
    }

    .block_1 p a {
        color: #006acd;
        text-decoration: underline;
    }

    .block_1 .box_22 {
        background: #f1f1f1;
        padding-bottom: 2px;
        overflow: hidden;
    }

    .block_1 .box_1 {
        border: 1px solid #CBCBCB;
        background-color: #fff;
    }

    .block_1 h6 {
        height: 39px;
        line-height: 39px;
        border-bottom: 1px solid #e5e5e5;
        background-color: #f5f5f5;
        color: #333333;
        text-indent: 20px;
    }

    .block_1 h6 span {
        float: left;
        padding-left: 15px;
    }

    .block_1 .RelaArticle a, .alone {
        background: url("{{path('images/bg.gif')}}") no-repeat 0px -170px;
        padding: 0px 0px 0px 10px;
        color: #3f3f3f;
        text-decoration: none;
    }

    .block_1 .RelaArticle a:hover {
        background: url("{{path('images/bg.gif')}}") no-repeat 0px -170px;
        padding: 0px 0px 0px 10px;
        color: #ff6600;
        text-decoration: none;
    }
</style>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')

    <div class="block_1">
        <div class="box_22">
            <div class="box_1">
                <h6><span>系统提示</span></h6>
                <div class="boxCenterList RelaArticle" align="center">
                    <div style="margin:20px auto;">
                        <p style="font-size: 14px; font-weight:bold; color: red;">{{$msg or '您请求的页面不存在'}}</p>
                        <p><a href='{{$link1 or route('index')}}'>{{$link1_text or '返回首页'}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection