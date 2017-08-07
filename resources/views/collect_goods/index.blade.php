@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/my_collect2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/change_num.js')}}"></script>
<script type="text/javascript" src="{{path('js/delete.js')}}"></script>
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
                    {{route('collect_goods.index')}}
                @endslot
                @slot('title3')
                    我的收藏
                @endslot
                @slot('right')

                @endslot


                <table class="gwc_tb2">
                    <tr>
                        <th><input type="checkbox" class="allselect check_all" onclick="check_all($(this))"/> 全选</th>
                        <th>商品名称</th>
                        <th>生产厂家</th>
                        <th>包装单位</th>
                        <th>规格</th>
                        <th>价格</th>
                        <th style="width: 113px;">操作</th>
                    </tr>
                    @forelse($result as $v)
                        <tr id="{{$v->goods_id}}" data-id="{{$v->goods_id}}-1">
                            <td class="tb2_td1">
                                <input onclick="is_check('id_check','check_all')" class="id_check" type="checkbox"
                                       value="{{$v->goods_id}}" name="ids[]"/>
                            </td>
                            <td class="tb2_td2"><a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                            src="{{$v->goods->goods_thumb}}" alt="{{$v->goods->goods_name}}"
                                            title="{{$v->goods->goods_name}}"/></a>
                                <p class="name">{{str_limit($v->goods->goods_name,10)}}</p></td>
                            <td class="tb2_td3" alt="{{$v->goods->sccj}}"
                                title="{{$v->goods->sccj}}">{{str_limit($v->goods->sccj,12)}}</td>
                            <td class="tb2_td3">{{str_limit($v->goods->dw,12)}}</td>
                            <td class="tb2_td3">{{str_limit($v->goods->spgg,12)}}</td>
                            <td class="tb2_td6"><span
                                        class="subtotal">@if($user->ls_review==1){{formated_price($v->goods->real_price)}}@else
                                        会员可见 @endif</span></td>
                            <td class="tb2_td8">
                                <a @if($v->goods->is_can_buy==1) onclick="tocart({{$v->goods_id}})"
                                   @else onclick="tocart1()" @endif
                                   class="cart"><img title="加入购物车"
                                                     src="{{path('images/shopping_cart1.jpg')}}"></a>
                                <a url="{{route('collect_goods.destroy',$v->rec_id)}}" method="delete"
                                   title="您确定要从收藏夹中删除选定的商品吗？"
                                   onclick="delete_cz($(this))" class="cancel"><img
                                            title="取消收藏" src="{{path('images/shopping_del.jpg')}}"></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">暂无收藏商品！</td>
                        </tr>
                    @endforelse
                </table>
                {!! $result->links('layouts.page',['show_num'=>2,'html2'=>'<div class="control">
                    <div class="con_left">
                        <input type="checkbox" id="" class="allselect check_all" onclick="check_all($(this))"/> 全选
                        <input type="button" id="" value="加入购物车" class="submit" onclick="plgm()"/>
                        <a id="cancel1" class="cancel" onclick="plsc(\''.route('collect_goods.plsc').'\',\'确定取消收藏吗？\')">取消收藏</a>
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
