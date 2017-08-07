@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/balance2.css')}}" rel="stylesheet" type="text/css"/>
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
                    {{route('user.account_log')}}
                @endslot
                @slot('title3')
                    余额管理
                @endslot
                <table class="table2">
                    <tr>
                        <th class="case1">操作时间</th>
                        <th>类型</th>
                        <th>余额</th>
                        <th>备注</th>

                    </tr>
                    @forelse($result as $v)
                        <tr>
                            <td class="tb2_td1">{{date('Y-m-d',$v->change_time)}}</td>
                            <td class="tb2_td2">@if($v->user_money>0)增加@else减少@endif</td>
                            <td class="tb2_td3">{{formated_price(abs($v->user_money))}}</td>
                            <td class="tb2_td4" title="{!! $v->change_desc !!}">{!! $v->change_desc !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">没有记录</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="4" class="al_right"><p class="balance" style="font-size: 16px;">
                                您当前的可用资金为:{{formated_price($user->user_money)}}</p></td>
                    </tr>
                </table>
                {!! $result->links('layouts.page',['show_num'=>2]) !!}
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
