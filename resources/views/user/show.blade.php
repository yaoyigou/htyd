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
                    {{route('user.show',['id'=>$user->user_id])}}
                @endslot
                @slot('title3')
                    基本信息
                @endslot
                <div class="content">
                    <form name="formEdit" action="{{route('user.update',['id'=>$user->user_id])}}" method="put"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <table>
                            <tr>
                                <td class="title">出生日期：</td>
                                <td>
                                    <select name="year">
                                        {!! $year or '' !!}
                                    </select>&nbsp;
                                    <select name="month">
                                        {!! $month or '' !!}
                                    </select>&nbsp;
                                    <select name="day">
                                        {!! $day or '' !!}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="title">性别：</td>
                                <td>
                                    <input type="radio" name="sex" value="0"
                                           @if($user->sex==0)checked="checked"@endif />保密
                                    <input type="radio" name="sex" value="1"
                                           @if($user->sex==1)checked="checked"@endif />男
                                    <input type="radio" name="sex" value="2"
                                           @if($user->sex==2)checked="checked"@endif />女
                                </td>

                            </tr>

                            <tr>
                                <td class="title">电子邮件地址：</td>
                                <td><input name="email" type="text" value="{{$user->email}}" size="25"
                                           class="com email"/> <span class="xinghao">*</span></td>
                            </tr>
                            <tr>
                                <td class="title">上传头像：</td>
                                <td><p><input type="file" name="ls_file"/><input type="hidden" name="ls_file1"
                                                                                 value="{{$user->ls_file}}"/></p> <span
                                            class="file_ico"><img
                                                src="{{path('images')}}@if($user->ls_file)/yes.gif @else/no.gif @endif"/></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="title">企业名称：</td>
                                <td><input name="msn" type="text" class="com" readonly value="{{$user->msn}}"/><span
                                            class="txt">如需更改请联系客服人员！</span></td>
                            </tr>
                            <tr>
                                <td class="title">QQ：</td>
                                <td><input name="qq" type="text" class="com" value="{{$user->qq}}"/></td>
                            </tr>
                            <tr>
                                <td class="title">联系电话：</td>
                                <td><input name="mobile_phone" type="text" class="com" value="{{$user->mobile_phone}}"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="btn1">
                                    <input name="submit" type="submit" value="确认修改" class="revise"/>
                                    <input name="act" type="hidden" value="act_edit_profile"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <form name="formPassword" action="{{route('user.update',['id'=>$user->user_id])}}" method="put">
                        {!! csrf_field() !!}
                        <table class="table2">
                            <tr>
                                <td class="title">原密码：</td>
                                <td><input name="old_password" type="password"
                                           class="com ypsw"/>&nbsp;{!! $errors->first('old_password','<span style="color: red">:message</span>') !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="title">新密码：</td>
                                <td><input name="password" type="password"
                                           class="com npsw"/>&nbsp;{!! $errors->first('password','<span style="color: red">:message</span>') !!}
                                </td>
                            </tr>

                            <tr>
                                <td class="title">确认密码：</td>
                                <td><input name="password_confirmation" type="password" class="com cpsw"/></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="btn1 btn2">
                                    <input name="submit" type="submit" class="revise revise2" value="确认修改"/>
                                    <input name="act" type="hidden" value="act_edit_password"/>
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
            @endcomponent
            @include('layouts.user_menu')
        </div>

    </div>
    @include('layouts.footer')
    @include('layouts.fix_search')
    @include('layouts.fix_right')
@endsection
