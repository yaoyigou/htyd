@extends('layout.body')
@section('links')
    @include('layout.token')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/attach_left.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/help.css')}}" rel="stylesheet" type="text/css"/>


    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.boxy.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.cookie.js')}}"></script>
    @include('common.ajax_set')
    <style type="text/css">
        /*右边内容*/
        .right-con{ width:770px; float:right; padding-top:8px; font-size:14px; padding-bottom:80px;}
        .min-bread em{ display:block; height:13px; width:3px; float:left; background:#1369c0;}
        .min-bread { line-height:15px; border-bottom:1px solid #dfdfdf; padding-bottom:18px;}
        .min-bread a{margin:0 13px;}
        .min-bread a:hover{ color:#666;}
        .dgfs{ padding-left:19px;}
        .dgfs h3{ font-weight:400; font-size:18px; margin-bottom:21px; font-family:"microsoft yahei";}
        /*意见反馈*/
        .feed { padding:40px 0 0 10px; height:auto; overflow:hidden;}
        .feed h3{ line-height:30px;}
        .form-box{ padding-left:30px;}
        .feed-cs{ padding:30px 0 20px 0;}
        .feed-cs input{vertical-align:middle; *margin-top:2px; margin-right:5px;}
        .feed-cs label{ margin-right:10px;}
        .feed-email input{ width:300px; height:36px; line-height:36px; vertical-align:middle; margin:0 14px 0 5px; padding-left:8px;}
        .feed-email input ,.feed-text textarea{ border:1px solid #ddd; outline:none;}
        .feed-email label , .feed-email input ,.feed-email .err{ display:inline;}
        .feed-email .err , .oos-box .err{ display:inline-block; *display:inline;}
        .feed-text{ padding-top:20px; clear:both;}
        .feed-text textarea{ width:590px; height:215px; padding-left:10px; resize:none; color:#c3c3c3;}
        .feed-text span{ float:left; padding:0 6px 0 29px; *padding-left:23px;}
        .err ,.phone .correct{
            height:15px; line-height:15px; color:#e3383c; background:url(//img.jianke.com/jk2016/help/images/icon.png) no-repeat left -27px;
            padding-left:23px; display:inline-block; visibility:hidden;
        }
        .feed .sub-box{ padding:10px 0 0 73px;}
        .feed .sub-box .sub ,.txt-box button{
            width:158px; height:40px; background:url(//img.jianke.com/jk2016/help/images/submit.jpg) no-repeat center; margin-top:18px; cursor:pointer;
            border:0; display:block;
        }
        .txt-box button{ margin-left:37px; float:left;}
    </style>
@endsection
@section('content')
    @include('layout.page_header_help')

    <div class="help_container">
        <div class="main_left">
            @include('layout.articleTree')
        </div>
        <div class="main_right">
            <div class="top">
                <span class="title">当前位置:</span>
                <a class="end"><span></span></a><a href="{{route('index')}}">首页</a>
                <code>&gt;</code> <a href="/article?id=3">帮助中心</a>
                <code>&gt;</code> <a href="/feedback">用户反馈</a>
            </div>
            <div class="feed">
                <h3 style="font-size: 20px;">您对合纵医药网有任何意见和建议，或在使用过程中遇到问题，请在本页面反馈。我们会每天关注您的反馈，不断优化产品，为您提供更好的服务！</h3>
                <div class="form-box">
                    <form action="{{route('user.feedback')}}" method="post">
                        {!! csrf_field() !!}
                        <div class="feed-cs" id="radio">
                            您反馈类型：
                            <label><input value="1" name="type" checked="checked"
                                          type="radio"><span>药品咨询</span></label>
                            <label><input value="2" name="type" type="radio"><span>首页意见建议</span></label>
                            <label><input value="3" name="type" type="radio"><span>服务投诉</span></label>
                            <label><input value="4" name="type" type="radio"><span>服务表扬</span></label>
                            <label><input value="5" name="type" type="radio"><span>问题报告</span></label>
                        </div>
                        <div class="feed-email"><label>手机/邮箱：</label><input id="celORmail" name="connect_info" value="" type="text">
                            <p class="err">电话/邮箱至少填写一项</p>
                        </div>
                        <div class="feed-text">
                            <span>内容：</span>
                            <textarea maxlength="1000" class="fetext" id="content" style="color: rgb(195, 195, 195);">请尽量填写10-1000字，以便我们及时给您回复</textarea>
                            <div class="sub-box">
                                <p class="err">请至少填写10字以上</p>
                                <input value=" " class="sub" onclick="AddAdvice();" type="button">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">

        /*意见反馈*/
        $(document).ready(function(){
            $('.feed-email input').blur(function(){
                var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
                var emg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                if (reg.test($(this).val()) || emg.test($(this).val())) {
                }else{
                    $('.feed-email .err').css('visibility','visible');
                }
                $('.sub-box .err').css('visibility','hidden');
            });
            $('.feed-email input').focus(function(){
                $('.feed-email .err').css('visibility','hidden');
                $('.sub-box .err').css('visibility','hidden');
            });
            $('.fetext').blur(function(){
                if($(this).val().length < 10){
                    $('.sub-box .err').css('visibility','visible');
                }
                if($(this).val() ==''){
                    $(this).val('请尽量填写10-1000字，以便我们及时给您回复');
                    $(this).css('color','#c3c3c3');
                }else{
                    $(this).css('color','#333');
                }
            });
            $('.fetext').focus(function(){
                $('.sub-box .err').css('visibility','hidden');
                if($(this).val() =='请尽量填写10-1000字，以便我们及时给您回复'){
                    $(this).val('');
                    $(this).css('color','#333');
                }else{
                    $(this).css('color','#333');
                }
            });
        });
        function AddAdvice() {
            if ($(".form-box").html().indexOf("visible") < 0 && $("#celORmail").val() != "" && $("#content").val().indexOf("请尽量填写10-1000字")<0) {
                var celORmail = $("#celORmail").val();
                $.ajax({
                    url:'/user/feedback',
                    data:{type:$("#radio input:checked").val(),connect_info:celORmail,msg_content:$("#content").val()},
                    dataType:'json',
                    success:function (data) {
                        add_tanchuc(data.msg)
                    }
                });
            }
        }
    </script>
    @include('layout.page_footer_help')
@endsection
