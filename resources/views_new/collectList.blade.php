@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_collect2.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/my_collect.js')}}"></script>
    <style type="text/css">

        .listPageDiv {
            height: 50px;
            line-height: 50px;
            text-align: right;
            margin-top: 10px;
            float: right;
            width: 70%;
            color: #333333;
            font-family: "Microsoft YaHei"
        }

        .pageList {
            width: 490px;
            float: left;
        }

        .listPageDiv .p1 {
            border: 1px #CCC solid;
            padding: 4px 9px;
            margin: 3px;
            background-color: #efefef;
        }

        .listPageDiv .p_ok {
            color: #39a817;
            border: 0;
            background-color: #fff;
        }

        .listPageDiv a {
            color: #666;
        }

        .listPageDiv a:hover {
            text-decoration: underline;
            color: #39a817;
        }

        .listPageDiv .no {
            background-color: #fff;
        }

        .listPageDiv .no a {
            color: #cccccc;
        }

        .listPageDiv .page_inout {
            width: 24px;
            height: 24px;
            border: 1px solid #ccc;
            margin: 0 5px;
            line-height: 24px;
            text-align: center;
        }

        .listPageDiv .submit {
            cursor: pointer;
            width: 45px;
            height: 24px;
            line-height: 20px;
            background-color: #efefef;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .listPageDiv .submit_input {
            padding-left: 10px;
            width: 180px;
            float: right;
            _margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="main fn_clear">

        <div class="top">
            <span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>我的收藏</span></a> </div>

        @include('layout.user_menu')

        <div class="main_right1 slideTxtBox">
            <div class="top_title hd">
                <h3>我的收藏</h3>
                <ul class="nav_title_1">
                    <li @if($type==0)class="on"@endif ><a href="{{route('user.collectList')}}">全部</a></li>
                    <li @if($type==2)class="on"@endif ><a href="{{route('user.collectList',['type'=>2])}}">精品专区</a></li>
                    <li @if($type==3)class="on"@endif ><a href="{{route('user.collectList',['type'=>3])}}">推介专区</a></li>
                    <li @if($type==1)class="on"@endif ><a href="{{route('user.collectList',['type'=>1])}}">普药</a></li>
                    <li @if($type==4)class="on"@endif ><a href="{{route('user.collectList',['type'=>4])}}">中药饮片</a></li>
                </ul>
                <span class="ico"></span>
            </div>
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




        </div>

    </div>
    <!-- 加入购物车弹出层begin -->
    <div class="comfirm_buy" style="display:none;" id="shopping_box">
        <div class="content_buy"><a href="#" class="success"></a>
            <h4>&nbsp;</h4>
            <p class="tip_txt" alt="" title="">&nbsp;</p>

            <p class="login_p tab_p1" style="display: none;">
                <a class="login_a again">继续购物</a> <a href="/cart">去结算 ></a>
            </p>

            <p class="login_p tab_p2" style="display: none;">
                <a href="/auth/login" class="login_a">登录</a> <a href="/auth/register">注册</a>
            </p>

            <p class="login_p tab_p3" style="display: none;">
                <a href="requirement.php" class="login_a">去登记</a> <a class="login_a again">取消</a>
            </p>

            <p class="login_p tab_p4" style="display: none;">
                <a class="login_a confirm again">确认</a>
            </p>

            <p class="login_p tab_p5" style="display: none;">
                <a href="#" class="login_a confirm">确认</a>
            </p>

            <span class="close2"></span>
        </div>
    </div>
    <!-- 加入购物车弹出层end -->
    @include('common.footer')
@endsection
