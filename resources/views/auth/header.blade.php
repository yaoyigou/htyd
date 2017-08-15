<div class="site-header">
    <div class="header-box">
        <div class="logo">
            <a href="{{route('index')}}"><img src="{{path('images/login_logo.png')}}"/></a>

        </div>
        <p class="dl">{{$page_title or '会员登录'}}</p>
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