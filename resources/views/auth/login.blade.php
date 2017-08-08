@extends('layouts.app')
@push('header')
<link rel="stylesheet" type="text/css" href="{{path('css/login.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/log_reg_common.css')}}"/>
<link href="http://www.hezongyy.com/css/confirm_psw.css?20170502" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/login.js')}}"></script>
@endpush
@section('content')
    @include('auth.header')
    <div class="site-content"
         style='background: url("{{path('images/login_bg.jpg')}}") no-repeat scroll center top;'>
        <div class="content-box">
            {{--<a target="_blank" href="/category?step=drt"--}}
            {{--style="display: block;width: 100%;height: 546px;position: absolute;right: 400px;"></a>--}}
            <div class="right">
                <div class="right-title fn_clear">
                    <h2>欢迎登录</h2>
                    <div class="wangji">
                        <span>还没有账号？<a href="/register">快速注册</a> </span>
                    </div>
                </div>

                <p class="input-box">
                    <span class="ico"></span><label for="username">
                        <span class="codes2" style="display: block;">用户名</span>
                        <input class="username txt" id="username" name="user_name" type="text"
                               style="color: rgb(51, 51, 51);"></label>
                    <span class="prompt2">请输入用户名</span>
                </p>
                <p class="input-box"><span class="ico pas"></span> <label for="password">
                        <span class="codes" style="display: block;">密　码</span>
                        <input class="password txt" id="password" name="password" type="password"
                               style="color: rgb(51, 51, 51);"></label>
                    <span class="prompt2">请输入密码</span>
                </p>

                <a href="javascript:void(0)" class="login">登　录</a>
                <input type="hidden" name="act" class="act" value="ajax_act_login">
                <input type="hidden" name="back_act" class="back_act" value="/index.php">

                <div class="box"><span><input type="checkbox" value="1" name="remember"
                                              id="remember">&nbsp;&nbsp;记住账号</span>
                    {{--<a href="http://www.hezongyy.com/password/email">忘记密码</a>--}}
                </div>
            </div>

        </div>

    </div>
    @include('auth.footer')
@endsection
