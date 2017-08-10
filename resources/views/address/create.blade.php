@extends('layouts.app')
@push('header')
<link href="{{path('css/index/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/cart.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('css/flow-consignee.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/flow.js')}}"></script>
<script type="text/javascript" src="{{path('js/region.js')}}"></script>
<style>
    .cj_type1 {
        width: 1200px;
        margin: 0 auto;
        height: 178px;
        background: url("{{path('images/cj_03.jpg')}}") no-repeat;
        position: relative;
    }

    .cj_type2 {
        width: 1200px;
        margin: 0 auto;
        height: 178px;
        background: url("{{path('images/zhongjiang_banner.jpg')}}") no-repeat;
        position: relative;
    }

    .cj_type3 {
        width: 1200px;
        margin: 0 auto;
        height: 178px;
        background: url("{{path('images/zhongjiang_banner2.jpg')}}") no-repeat;
        position: relative;
    }

    .cj_bm {
        color: #ff5100;
        position: absolute;
        top: 75px;
        right: 340px;
        height: 40px;
        width: 200px;
        text-align: left;
        font-size: 24px;
    }
</style>
@endpush
@section('content')
    @include('cart.header')
    <div class="content">
        @component('component.form',['action'=>route('address.store'),'method'=>'post'])
            <input type="hidden" name="action" value="jiesuan"/>
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
                        <select name="province" class="select2" onchange="show_region_list($(this),'city')">
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
                        <input name="submit" class="revise submit" value="配送至这个地址" type="submit">
                    </td>
                </tr>
            </table>
        @endcomponent
    </div>
    @include('layouts.footer')
@endsection
