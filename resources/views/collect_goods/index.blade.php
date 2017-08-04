@extends('layouts.app')
@push('css')
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

                @endslot
                    <div  class="content_box"  >

                        <form action="{{route('user.plBuy')}}" method="get" id="form">
                            <table class="gwc_tb2">
                                <tr>
                                    <th><input type="checkbox" id="Checkbox1" class="allselect"/> 全选 </th>
                                    <th>商品名称</th>
                                    <th>生产厂家</th>
                                    <th>包装单位</th>
                                    <th>规格</th>
                                    <th>价格</th>
                                    <th>采购次数</th>
                                    <th style="width: 113px;">操作</th>
                                </tr>
                                @if(count($pages)>0)
                                    @foreach($pages->goods as $v)
                                        <tr id="{{$v->goods_id}}" data-id="{{$v->goods_id}}-1">
                                            <td class="tb2_td1"><input type="checkbox" value="{{$v->goods_id}}" name="ids[]" dd-id="newslist" /></td>
                                            <td class="tb2_td2"><a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a> <p class="name">{{str_limit($v->goods_name,10)}}</p></td>
                                            <td class="tb2_td3" alt="{{$v->sccj}}" title="{{$v->sccj}}">{{str_limit($v->sccj,12)}}</td>
                                            <td class="tb2_td3">{{str_limit($v->dw,12)}}</td>
                                            <td class="tb2_td3">{{str_limit($v->spgg,12)}}</td>
                                            <td class="tb2_td6"><span class="subtotal">@if($user->ls_review==1){{formated_price($v->real_price)}}@else 会员可见 @endif</span></td>
                                            <td class="tb2_td7">{{$v->cgcs or 0}}次 </td>
                                            <td class="tb2_td8">
                                                <a href="javascript:@if($v->is_can_buy==1) addToCart1({{$v->goods_id}},1)@else addToCart2({{$v->goods_id}}) @endif" class="cart"><img title="加入购物车" src="{{path('images/shopping_cart1.jpg')}}"></a>
                                                <a href="{{route('user.deleteCollect',['id'=>$v->rec_id])}}" onclick="return confirm('您确定要从收藏夹中删除选定的商品吗？')" class="cancel"><img title="取消收藏" src="{{path('images/shopping_del.jpg')}}"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">暂无收藏商品！</td>
                                    </tr>
                                @endif
                            </table>


                            <div class="control">
                                <div class="con_left">
                                    <input type="checkbox" id="Checkbox2" class="allselect"/> 全选
                                    <input type="submit" id='submit_0' value="加入购物车" class="submit"/>
                                    <a id='cancel1' class="cancel">取消收藏</a>
                                    <input type="hidden" value="{{route('user.deleteCollectPl')}}" id="action"/>
                                </div>



                            </div>
                        </form>
                        @if($pages->lastPage()>0)
                            {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['type'=>$type,'url'=>'user.collectList']) !!}
                        @endif
                    </div>
                {!! $result->links('layouts.page',['show_num'=>2]) !!}
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
