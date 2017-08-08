@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">

        .pingpai-box{width: 100%;padding: 60px 0 0px 0;}
        .pingpai-box .pingpai-list{width: 1200px;margin: 0 auto;overflow: hidden;}
        .pingpai-box .pingpai-list ul{width: 1400px;}
        .pingpai-box .pingpai-list ul li{position: relative;width: 260px;height: 375px;float: left;background-color: #f0f0f0;margin:0 54px 60px 0;}
        .pingpai-box .pingpai-list ul li  img{width: 260px;height: 375px;}

        .ppzq-box{width: 1300px;margin-top: 40px}
        .ppzq-box li{width: 565px;height: 330px;float: left;margin: 0 70px 70px 0;position: relative;}
        .ppzq-box li img{width: 565px;height: 330px;}


    </style>

@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    @if($ad117)
    <div class="pingpaizq"  style="background: url('{{$ad117->ad_code}}') no-repeat scroll center top;height: 400px;min-width: 1200px;overflow: hidden;width: 100%;">

    </div>
    @endif





    <div class="pingpai-box">
        <div class="pingpai-list">
            <ul class="list-first fn_clear" >
                @foreach($ppzq as $v)
                    <li>
                        <a href="@if(!empty($v->url)) {{$v->url}} @else {{route('category.index',['step'=>$v->rec_id,'showi'=>0])}} @endif" target="_blank"><img src="{{$v->img}}" alt="" /></a>
                    </li>
                @endforeach
            </ul>

        </div>

    </div>

    <div class="banner" style="width:1200px;height:95px;margin: 0 auto;position:relative;">
        <a href="{{route('ppzq.list')}}"><img src="{{get_img_path('images/pingpai.gif')}}" alt="" /></a>

    </div>


    <div class="tebietj" style="width:1200px;margin: 50px auto;position:relative;" >
        <div style="width:330px;height:70px;margin:20px auto;"><img src="{{get_img_path('images/pingpai-title.jpg')}}" alt="" /></div>
        <div style="width:1200px;position:relative;overflow:hidden;">
            <ul class="ppzq-box">
                @if(count($ad119)>0)
                    @foreach($ad119 as $v)
                        <li >
                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}" alt="" /></a>

                        </li>
                    @endforeach
                @endif
            </ul>
        </div>




    </div>

    @include('common.footer')

@endsection
