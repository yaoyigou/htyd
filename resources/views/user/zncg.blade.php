@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/purchase2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>
<script type="text/javascript" src="{{path('js/check_all.js')}}"></script>
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
                    {{route('user.zncg')}}
                @endslot
                @slot('title3')
                    智能采购
                @endslot
                <table class="gwc_tb2">
                    <tr>
                        <th><input type="checkbox" class="allselect check_all" onclick="check_all($(this))"/> 全选</th>
                        <th>商品</th>
                        <th>生产厂家</th>
                        <th>包装单位</th>
                        <th>规格</th>
                        <th>当前价格</th>
                        <th>采购次数</th>
                        <th>操作</th>
                    </tr>
                    @forelse($result as $v)
                        <tr id="{{$v->goods_id}}" data-id="{{$v->goods_id}}">
                            <td class="tb2_td1">
                                <input onclick="is_check('id_check','check_all')" class="id_check" type="checkbox"
                                       value="{{$v->goods_id}}" name="ids[]"/>
                            </td>
                            <td class="tb2_td2"><a href="{{$v->goods->goods_url}}"><img src="{{$v->goods->goods_thumb}}"
                                                                                        alt="{{$v->goods->goods_name}}"
                                                                                        title="{{$v->goods->goods_name}}"/></a>
                                <p class="name" alt="{{$v->goods->goods_name}}"
                                   title="{{$v->goods->goods_name}}">{{str_limit($v->goods->goods_name,12)}}</p></td>

                            <td class="tb2_td3" alt="{{$v->goods->sccj}}"
                                title="{{$v->goods->sccj}}">{{str_limit($v->goods->sccj,12)}}</td>

                            <td class="tb2_td4" alt="{{$v->goods->dw}}"
                                title="{{$v->goods->dw}}">{{str_limit($v->goods->dw,12)}}</td>

                            <td class="tb2_td5" alt="{{$v->goods->spgg}}"
                                title="{{$v->goods->spgg}}">{{str_limit($v->goods->spgg,12)}}</td>
                            <td class="tb2_td6">
                                @if($user->ls_review==1){{formated_price($v->goods->real_price)}}@else
                                    会员可见 @endif
                            </td>
                            <td class="tb2_td7">{{$v->count}}</td>
                            <td class="tb2_td8">
                                <a @if($v->goods->is_can_buy==1) onclick="tocart({{$v->goods_id}})"
                                   @else onclick="tocart1()" @endif>加入购物车</a>
                                <!-- 2015-6-26 -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">暂无商品！</td>
                        </tr>
                    @endforelse
                </table>
                {!! $result->links('layouts.page',['show_num'=>2,'html'=>'<div class="control">
                    <div class="con_left">
                        <input type="checkbox" id="" class="allselect check_all" onclick="check_all($(this))"/> 全选
                        <input type="button" id="" value="加入购物车" class="submit" onclick="plgm()"/>
                    </div>
             </div>']) !!}
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
