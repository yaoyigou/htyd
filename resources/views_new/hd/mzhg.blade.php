@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/cuxiaozhuanqu.css')}}" rel="stylesheet" type="text/css" />
    <style>
        #znq-daohang {
            right: 45px !important;
            bottom: 20px !important;
        }

    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')




    <div class="cxzq-top" style="width:100%;min-width:1200px;margin:0 auto;">
        <img style="width: 100%;height: 100%;display: block" src="{{get_img_path('images/'.$img_url)}}" alt="" />
    </div>

    <div class="cxzq-box">
        <div class="cxzq-list">
            <ul class="list-first fn_clear" style="padding-bottom:60px;">
                @if($show_li==1)
                    @include('common.mzhg1',['url'=>'/category?step=jrzz&showi=0'])
                @endif
                @foreach($mz as $v)
                    <li>
                        <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank"><img src="{{get_img_path($v->goods_img)}}" alt="" /></a>
                    </li>
                @endforeach

            </ul>

        </div>

    </div>
    @include('common.footer')
    @if(isset($daohang)&&$daohang==1)
        @include('miaosha.daohang')
    @endif
@endsection
