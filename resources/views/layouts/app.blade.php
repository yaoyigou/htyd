<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="baidu-site-verification" content="qUlVl7Atu0"/>
    <meta name="Keywords" content="{{shop_config('shop_keywords')}}"/>
    <meta name="Description" content="{{shop_config('shop_desc')}}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{$page_title or ''}}{{shop_config('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}"/>
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif"/>
    <link rel="alternate" type="application/rss+xml" title="RSS|{{$page_title or '系统提示'}}" href="feed.php"/>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/common/header.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('js/jquery.singlePageNav.min.js')}}"></script>
    <script type="text/javascript" src="{{path('js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('js/keywordsSearch.js')}}"></script>
    <script type="text/javascript" src="{{path('layer/layer.js')}}"></script>
    @yield('css')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            type: 'post',
//            beforeSend: function () {
//                layer.load(1, {
//                    shade: [0.1, '#fff'] //0.1透明度的白色背景
//                });
//            },
//            complete: function () {
//                layer.closeAll('loading');
//            },
        });
        layer.config({
            title: '温馨提示', //默认皮肤
            shade: 0
        });
    </script>
</head>

<body id="body" style="background-color: #ffffff;">
@yield('content')
</body>
@yield('js')
</html>
