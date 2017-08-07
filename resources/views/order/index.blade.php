@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/my_order2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/my_order.js')}}"></script>
@endpush
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            @component('component.user')
                @slot('title1')
                    交易管理
                @endslot
                @slot('title2')
                    {{route('order.index')}}
                @endslot
                @slot('title3')
                    我的订单
                @endslot
                @slot('right')
                    <div class="right_box">
                        <form action="{{route('order.index')}}" enctype="multipart/form-data" method="get">
                            <div class="search_box" id="search_box" style="margin-top: 0">
                                <input type="text" name="order_sn" class="keys" value="{{$order_sn}}"
                                       placeholder="订单编号"/>
                                <input type="submit" class="search" value="查询"><span class="ico"></span>
                            </div>
                            <select name="date">
                                {{--<option value="0">今天</option>--}}
                                <option value="0" @if($date==0) selected @endif>最近三个月</option>
                                <option value="1" @if($date==1) selected @endif>今年内</option>
                                {{--<option value="{{date('Y',strtotime('-1 year'))}}" @if($dates==date('Y',strtotime('-1 year'))) selected @endif>{{date('Y',strtotime('-1 year'))}}年</option>--}}
                                <option value="2" @if($date==2) selected @endif>往年订单</option>
                            </select>
                        </form>
                    </div>
                @endslot
                <table id="se">
                    <tr>
                        <th>订单标识</th>
                        <th>订单号</th>
                        <th>下单时间</th>
                        <th>收货人</th>
                        <th>订单总金额</th>
                        <th>订单状态</th>
                        <th> 操作</th>
                    </tr>
                    @if(count($result)>0)
                        @foreach($result as $v)
                            <tr>
                                <td>
                                    @if($v->jnmj>0)
                                        <a>返</a>
                                    @elseif($v->is_zq>0)
                                        <a>账</a>
                                    @elseif($v->is_separate==1)
                                        <a>货</a>
                                    @endif</td>
                                <td class="nub tb1_td1" data-id="{{$v->order_id}}"><a
                                            href="{{route('order.show',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">{{$v->order_sn}}</a>
                                </td>
                                <td class="date tb1_td2">{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                                <td class="name tb1_td3">{{$v->consignee}}</td>
                                <td class="score tb1_td4">{{formated_price($v->goods_amount)}}</td>
                                <td class="data tb1_td5">
                                    <span class="no_pay" style="color: #e70000;">@if($v->pay_status==2) 已付款 @else
                                            未付款 @endif</span>
                                    <span class="stat"
                                          style="color:#339900;cursor:pointer;position: relative;padding:0 5px;"
                                          id="ddgz" dd-url="{{route('order.ddgz')}}">订单跟踪</span>
                                </td>
                                <td class="result tb1_td6">&nbsp;
                                    {!! order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'handle') !!}
                                    <a href="{{route('order.show',['id'=>$v->order_id])}}"
                                       class="f6">查看订单</a>
                                    @if($v->mobile_pay<=1)
                                        <a href=""
                                           class="f6">再次购买</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">暂无任何订单！</td>
                        </tr>
                    @endif

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
