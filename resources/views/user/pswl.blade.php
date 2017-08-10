@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/logistics2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            @component('component.user')
                @slot('title1')
                    我的账号
                @endslot
                @slot('title2')
                    {{route('user.pswl')}}
                @endslot
                @slot('title3')
                    配送物流
                @endslot
                <div class="content_box">
                    <h4>配送物流</h4>
                    @if($user->shipping_id!=0)
                        <div class="content">
                            <p class="info">
                                <span class="box"><span class="title">物流名称：</span><span class="name"
                                                                                        style="color: #FF6102">{{$pswl}}</span></span>
                                <span class="box"><span class="title">(修改物流请联系客户)</span></span>
                            </p>
                            <p class="info">
                                <span class="box"><span class="title">物流电话：</span><span class="name"
                                                                                        style="color: #FF6102">{{$user->wl_dh}}</span></span>
                            </p>
                        </div>
                    @else
                        <div class="content">
                            <p class="info">
                                <span class="box"><span class="title">暂未选择物流配送信息。</span></span>
                            </p>
                        </div>
                    @endif

                </div>
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
