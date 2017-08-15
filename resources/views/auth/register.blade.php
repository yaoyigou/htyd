@extends('layouts.app')
@push('header')
<link rel="stylesheet" type="text/css" href="{{path('css/reg.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/log_reg_common.css')}}"/>
<link href="http://www.hezongyy.com/css/confirm_psw.css?20170502" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('js/register.js')}}"></script>
@endpush
@push('footer')
<script type="text/javascript">
    $(function () {


        $(".input-com").focus(function () {


            $(this).parent().find(".prompt2").addClass("hide");

        })


    })

</script>
@endpush
@section('content')
    <div class="site-header">
        <div class="header-box">
            <div class="logo">
                <a href="{{route('index')}}"><img src="{{path('images/login_logo.png')}}"/></a>

            </div>
            <p class="dl">会员注册</p>
            <p class="right">
                <a href="{{route('index')}}">返回首页</a>
                @if(isset($type)&&$type==1)
                    <a href="{{route('article.index',['type'=>2])}}">查看新闻中心</a>
                @else
                    <a href="{{route('article.index',['type'=>1])}}">查看帮助中心</a>
                @endif
            </p>
        </div>

    </div>
    <div class="site-content">

        <div class="content-container clear_float">
            @component('component.form',['action'=>'/register','method'=>'post','id'=>'register'])
                <div class="user-type-radio">

                    <span class="input-box-before">用户类型：</span>

                    <input type="radio" name="ls_lx" class="user-type" value="2" checked="checked"/>药店

                    <input type="radio" name="ls_lx" class="user-type" value="5"/>诊所

                    <input type="radio" name="ls_lx" class="user-type" value="1"/>连锁公司

                    <input type="radio" name="ls_lx" class="user-type" value="7"/>商业公司

                </div>

                <label class="input_box" for="username">

                    <span class="input-box-before">用户名：</span>

                    <input name="user_name" type="text" class="username input-com" id="username" value=" "
                           autocomplete="off"/>

                    <span class="prompt">*</span>
                    <span class="prompt2">请输入2-30个字符组成的用户名</span>

                </label>

                <label class="input_box" for="password">

                    <span class="input-box-before" for="password">密码：</span>

                    <input name="password" type="password" id="password" class="password input-com"/>

                    <span class="prompt">*</span>
                    <span class="prompt2">请输入6-24位英文、数字、"_"组成的密码</span>

                </label>

                <div class="pass_safe clear">

                    <span class="input-box-before">密码强度：</span>

                    <p class="after_clear"><span class="safe_level"> </span><span class="safe_level"> </span><span
                                class="safe_level"> </span></p>

                </div>

                <label class="input_box" for="confirm_password">

                    <span class="input-box-before">确认密码：</span>

                    <input name="password_confirmation" type="password" id="confirm_password"
                           class="sure_pass input-com"/>

                    <span class="prompt">*</span>

                </label>

                <label class="input_box email_label" for="email">

                    <span class="input-box-before">电子邮箱：</span>

                    <input name="email" type="text" class="email input-com" id="email" value="" autocomplete="off"/>

                    <span class="prompt">*</span>
                    <span class="prompt2">请输入有效的电子邮箱</span>

                    <div class="cemail">

                        <ul>

                            <li>@qq.com</li>

                            <li>@163.com</li>

                            <li>@126.com</li>

                            <li>@sohu.com</li>

                            <li>@sina.com</li>

                            <li>@hotmail.com</li>

                            <li>@gmail.com</li>

                            <li>@foxmail.com</li>

                            <li>@139.com</li>

                            <li>@189.cn</li>

                        </ul>

                    </div>

                </label>

                <label class="input_box" for="ls_name">

                    <span class="input-box-before">真实姓名：</span>

                    <input name="ls_name" type="text" id="ls_name" class="real_name input-com" value=""
                           autocomplete="off"/>

                    <span class="prompt"></span>

                </label>

                <label class="input_box" for="enterprise">

                    <span class="input-box-before">企业名称：</span>

                    <input class="enterprise input-com" type="text" name="msn" id="enterprise" value=""
                           autocomplete="off"/>

                    <span class="prompt ">*</span>
                    <span class="prompt2">请填写与营业执照上名称一致，以便尽快通过审核</span>

                </label>

                <label class="input_box" for="extend_field2">

                    <span class="input-box-before">QQ：</span>

                    <input class="qq input-com" type="text" name="qq" id="extend_field2" value="" autocomplete="off"/>

                    <span class="prompt ">*</span>

                </label>

                <label class="input_box" for="extend_field5">

                    <span class="input-box-before">联系电话：</span>

                    <input class="phone input-com" type="text" name="mobile_phone" id="extend_field5" value=""
                           autocomplete="off"/>

                    <span class="prompt">*</span>
                    <span class="prompt2">请输入正确的电话号码，座机格式：xxx-xxxxxx</span>

                </label>


                <div class="choose_address fn_clear">

                    <span class="ca_tip">所在地区：</span>

                    <div class="select choose_select province" style="margin-left: 0px;">

                        <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                        <ul class="select_options">

                            <li data-id="0" style="border: 0">请选择</li>
                            <li data-id="2">北京</li>
                            <li data-id="3">安徽</li>
                            <li data-id="4">福建</li>
                            <li data-id="5">甘肃</li>
                            <li data-id="6">广东</li>
                            <li data-id="7">广西</li>
                            <li data-id="8">贵州</li>
                            <li data-id="9">海南</li>
                            <li data-id="10">河北</li>
                            <li data-id="11">河南</li>
                            <li data-id="12">黑龙江</li>
                            <li data-id="13">湖北</li>
                            <li data-id="14">湖南</li>
                            <li data-id="15">吉林</li>
                            <li data-id="16">江苏</li>
                            <li data-id="17">江西</li>
                            <li data-id="18">辽宁</li>
                            <li data-id="19">内蒙古</li>
                            <li data-id="20">宁夏</li>
                            <li data-id="21">青海</li>
                            <li data-id="22">山东</li>
                            <li data-id="23">山西</li>
                            <li data-id="24">陕西</li>
                            <li data-id="25">上海</li>
                            <li data-id="26">四川</li>
                            <li data-id="27">天津</li>
                            <li data-id="28">西藏</li>
                            <li data-id="29">新疆</li>
                            <li data-id="30">云南</li>
                            <li data-id="31">浙江</li>
                            <li data-id="32">重庆</li>
                            <li data-id="33">香港</li>
                            <li data-id="34">澳门</li>
                            <li data-id="35">台湾</li>

                        </ul>

                    </div>

                    <div class="select choose_select city" style="margin-left: 0px;">

                        <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                        <ul class="select_options"></ul>

                    </div>

                    <div class="select choose_select district" style="margin-left: 0px;margin-right:40px;">

                        <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                        <ul class="select_options"></ul>

                    </div>

                    <span class="prompt margin_problem">*</span>
                    <input type="hidden" name="province" value="" id="province"/>
                    <input type="hidden" name="city" value="" id="city"/>
                    <input type="hidden" name="district" value="" id="district"/>
                </div>


                <label class="agree">

                    <span class="input-box-before">&nbsp;</span>

                    <input name="agreement" type="checkbox" value="1" checked="checked"/>

                    我已看过并接受<a href="http://www.hezongyy.com/articleInfo?id=73" target="_blank">《用户协议》</a> </label>

                <a href="javascript:;" id="submit"/>
                提交注册
                </a>

                <p class="reg_other">

                    <span class="input-box-before">&nbsp;</span>

                    <a href="http://www.hezongyy.com/auth/login" class="want_login after_clear">我已有账号，我要登录</a>&nbsp;&nbsp;

                    {{--<a href="http://www.hezongyy.com/password/email" style="margin-left: 87px;">您忘记密码了吗？</a>--}}

                </p>
            @endcomponent

        </div>

    </div>
    @include('auth.footer')
@endsection
