<div id="header">
    <!--登陆注册一栏-->
    <div class="top_box" style="border: none;">
        <div class="top">
            <div class="top_left">

            </div>
            <ul class="jkn_head_t_r">
                <li style="float: left;">
                    @if($user)
                        <div class="login_after" style="display:block;">

                            <div class="username" alt="{{$user->user_name}}" title="{{$user->user_name}}">
                                <div class="UserId">{{$user->user_name}}<span
                                            style="color: #4c4b4b;">，欢迎来到浩天于达商城！</span></div>

                            </div>

                            <a href="/logout" class="out">[&nbsp;退出&nbsp;]</a>
                        </div>
                        <div class="my_name-box">
                            <a href="/user" class="my_name">
                                会员中心
                            </a>
                            {{--<div class="gerenxinxi">--}}
                            {{--<img src="http://www.hezongyy.com/new/images/gerenxinxi-top.png?20170502"--}}
                            {{--style="position: absolute;top: -7px;left:30px;"/>--}}
                            {{--<div class="touxiangimg">--}}
                            {{--<a href="#"><img--}}
                            {{--src="http://www.hezongyy.com/new/images/gerentouxiang.png?20170502"/></a>--}}
                            {{--</div>--}}
                            {{--<div class="weizhi" style="color: #767676;">--}}
                            {{--<a style="margin-left:15px;" href="/user">药易购测试罗悦1</a>--}}
                            {{--</div>--}}
                            {{--<div class="mingzi">--}}
                            {{--<a href="#" style="color:#999999;margin-left:15px;">药店</a>--}}

                            {{--</div>--}}
                            {{--<ul class="userfunc">--}}
                            {{--<li>--}}
                            {{--<a href="/user/orderList" style="color: white;">我的订单</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a target="_blank" href="/jf/member" style="color: white;">我的积分</a>--}}
                            {{--</li>--}}
                            {{--<li style="border: none;">--}}
                            {{--<a href="/user/zncg" style="color: white;">智能采购</a>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                        </div>
                    @else
                        <div class="login_before">
                            <span style="float: left;color: #333;">您好，欢迎来到合纵医药网！</span>
                            <div class="login_before1">
                                <a href="/login">
                                    <div class="loginbtn">登录</div>
                                </a>
                                <span class="separate2"></span>
                                <a href="/register" class="reg" style="color:#333;">
                                    注册
                                </a>
                            </div>
                        </div>
                    @endif
                    <span style="color: #cecece;">|</span>
                </li>
                <li class="my_jianke" style="float: left;">
                    <img src="{{path('images/index/aixin.png')}}"/>
                    <a target="_blank" href="{{route('collect_goods.index')}}">
                        我的收藏
                    </a>
                </li>
                <li class="my_jianke" style="padding-left: 10px;float: left;">
                    <a target="_blank" href="{{route('article.index')}}">帮助中心</a>
                </li>

            </ul>

        </div>
    </div>
    <!--登陆注册一栏结束-->

</div>