<div class="site-header">
    <div class="header-box">
        <div class="logo">
            <a href="{{route('index')}}"><img src="{{path('images/login_logo.png')}}"/></a>

        </div>
        <p class="dl">{{$top_title or '会员登录'}}</p>
        <p class="right">
            <a href="{{route('index')}}">返回首页</a>
            <a href="{{route('article.index')}}">查看帮助中心</a>
        </p>
    </div>

</div>