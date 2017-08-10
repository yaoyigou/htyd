@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/member2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/address2.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/nav.js')}}"></script>
<script type="text/javascript" src="{{path('js/flow.js')}}"></script>
<script type="text/javascript" src="{{path('js/region.js')}}"></script>
<script type="text/javascript" src="{{path('js/delete.js')}}"></script>
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
                    {{route('address.index')}}
                @endslot
                @slot('title3')
                    收货地址
                @endslot
                <div class="content">
                    @foreach($result as $k=>$v)
                        @component('component.form',['action'=>route('address.update',['id'=>$v->address_id]),'method'=>'put'])
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="title">收货人姓名：</td>
                                    <td><input name="consignee" type="text" class="com names"
                                               value="{{$v->consignee}}"/> 必填
                                    </td>
                                    <td class="title">电子邮件地址：</td>
                                    <td><input name="email" type="text" class="com email" value="{{$v->email}}"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title">收货地址：</td>
                                    <td colspan="3">
                                        <select name="province" class="select2"
                                                onchange="show_region_list($(this),'city')">
                                            <option value="0">请选择</option>
                                            @foreach($province as $k1=>$v1)
                                                <option @if($v->province==$k1) selected
                                                        @endif value="{{$k1}}">{{$v1}}</option>
                                            @endforeach
                                        </select>
                                        <select name="city" class="select3 city"
                                                onchange="show_region_list($(this),'district')">
                                            <option value="0">请选择</option>
                                            @foreach($v->city_list as $k1=>$v1)
                                                <option @if($v->city==$k1) selected
                                                        @endif value="{{$k1}}">{{$v1}}</option>
                                            @endforeach
                                        </select>
                                        <select name="district" class="select4 district">
                                            <option value="0">请选择</option>
                                            @foreach($v->district_list as $k1=>$v1)
                                                <option @if($v->district==$k1) selected
                                                        @endif value="{{$k1}}">{{$v1}}</option>
                                            @endforeach
                                        </select>
                                        <input name="address" type="text" class="com address" value="{{$v->address}}"/>
                                        必填
                                    </td>

                                </tr>
                                <tr>
                                    <td class="title">手机：</td>
                                    <td><input name="mobile" type="text" class="com phone" value="{{$v->mobile}}"/> 必填
                                    </td>
                                    <td class="title">电话：</td>
                                    <td><input name="tel" type="text" class="com" value="{{$v->tel}}"/></td>
                                </tr>
                                <tr>
                                    <td class="title">标志建筑：</td>
                                    <td><input name="sign_building" type="text" class="com"
                                               value="{{$v->sign_building}}"/></td>
                                    <td class="title">最佳送货时间：</td>
                                    <td><input name="best_time" type="text" class="com" value="{{$v->best_time}}"/></td>
                                </tr>
                                <tr>
                                    <td class="title">邮政编码：</td>
                                    <td colspan="3"><input name="zipcode" type="text" class="com"
                                                           value="{{$v->zipcode}}"/></td>
                                </tr>
                                <tr class="end">
                                    <td colspan="4" class="btn1">
                                        <input type="hidden" name="addressId" value=""/>
                                        <input name="submit" class="revise_1" value="确认修改" type="submit">
                                        <input name="button" class="revise_del" value="删除" type="button"
                                               url="{{route('address.destroy',['id'=>$v->address_id])}}"
                                               title="删除该收货地址" method="delete"
                                               onclick="delete_cz($(this),'form')">
                                    </td>
                                </tr>
                            </table>
                        @endcomponent
                    @endforeach
                    @if(count($result)<5)
                        @component('component.form',['action'=>route('address.store'),'method'=>'post'])
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="title">收货人姓名：</td>
                                    <td><input name="consignee" type="text" class="com names" value=""/> 必填
                                    </td>
                                    <td class="title">电子邮件地址：</td>
                                    <td><input name="email" type="text" class="com email" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title">收货地址：</td>
                                    <td colspan="3">
                                        <select name="province" class="select2"
                                                onchange="show_region_list($(this),'city')">
                                            <option value="0">请选择</option>
                                            @foreach($province as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                        <select name="city" class="select3 city"
                                                onchange="show_region_list($(this),'district')">
                                            <option value="0">请选择</option>

                                        </select>
                                        <select name="district" class="select4 district">
                                            <option value="0">请选择</option>
                                        </select>
                                        <input name="address" type="text" class="com address" value=""/> 必填
                                    </td>

                                </tr>
                                <tr>
                                    <td class="title">手机：</td>
                                    <td><input name="mobile" type="text" class="com phone" value=""/> 必填
                                    </td>
                                    <td class="title">电话：</td>
                                    <td><input name="tel" type="text" class="com" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="title">标志建筑：</td>
                                    <td><input name="sign_building" type="text" class="com" value=""/></td>
                                    <td class="title">最佳送货时间：</td>
                                    <td><input name="best_time" type="text" class="com" value=""/></td>
                                </tr>
                                <tr>
                                    <td class="title">邮政编码：</td>
                                    <td colspan="3"><input name="zipcode" type="text" class="com" value=""/></td>
                                </tr>
                                <tr class="end">
                                    <td colspan="4" class="btn1">
                                        <input type="hidden" name="addressId" value="0">
                                        <input name="submit" class="revise_1" value="新增收货地址" type="submit">
                                    </td>
                                </tr>
                            </table>
                        @endcomponent
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
