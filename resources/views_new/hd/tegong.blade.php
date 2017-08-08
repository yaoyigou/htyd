@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/tegongzhuanqu.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #container-tg {
            width: 100%;
            min-width: 1200px;
            background: url('{{get_img_path('images/tegong/tegong-bg.jpg')}}') no-repeat scroll top center;
        }
    </style>
    <script src="{{path('js/jquery.singlePageNav.min.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div id="container-tg" style="background-color: #3eb4fa;">
        <div class="container-box" style="height: 100%">
            <div class="tg-nav">
                <div class="tg-nav-box">
                    <a href="#zq-border" class="nav-zq">
                        <div class="nav-before"></div>
                        正清制药
                        <div class="nav-after"></div>
                    </a>
                    <a href="#mn" class="nav-mn">
                        <div class="nav-before"></div>
                        蒙牛乳业
                        <div class="nav-after"></div>
                    </a>
                    <a href="#dr" class="nav-drt">
                        <div class="nav-before"></div>
                        德仁堂
                        <div class="nav-after"></div>
                    </a>
                    <div class="kuang" style="width: 420px;height: 60px;">

                    </div>
                </div>
            </div>


            <div id="zq">
                <div id="zq-border"></div>
                <div class="zq-top">
                    <img src="{{get_img_path('images/tegong/tg-zhengqing.png')}}"/>
                </div>
                <div class="zq-content">
                    <ul>
                        <li style="background: url('{{get_img_path('images/tegong/zq-1.png')}}');">
                            <a target="_blank" href="/goods?id=27154" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=27154" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/zq-2.png')}}');">
                            <a target="_blank" href="/goods?id=27156" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=27156" class="img-btn-right"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/zq-3.png')}}');">
                            <a target="_blank" href="/goods?id=27155" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=27155" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/zq-4.png')}}');">
                            <a target="_blank" href="/goods?id=27371" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=27371" class="img-btn-right"></a>
                        </li>
                    </ul>
                </div>

            </div>
            <div id="mn" style="height: 1385px">
                <div class="mn-top">
                    <img src="{{get_img_path('images/tegong/tg-mn.png')}}"/>
                </div>
                <div class="mn-content">
                    <ul>
                        <li style="background: url('{{get_img_path('images/tegong/mn-1.png')}}');">
                            <a target="_blank" href="/goods?id=28200" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=28200" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/mn-2.png')}}');">
                            <a target="_blank" href="/goods?id=28211" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=28211" class="img-btn-right"></a>
                        </li>
                        {{--<li style="background: url('{{get_img_path('images/tegong/mn-7.png')}}');">--}}
                            {{--<a target="_blank" href="/goods?id=28210" class="tg-btn-left"></a>--}}
                            {{--<a target="_blank" href="/goods?id=28210" class="img-btn-left"></a>--}}
                        {{--</li>--}}
                        <li style="background: url('{{get_img_path('images/tegong/mn-8.png')}}');">
                            <a target="_blank" href="/goods?id=28205" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=28205" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/mn-4.png')}}');">
                            <a target="_blank" href="/goods?id=28212" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=28212" class="img-btn-right"></a>
                        </li>
                        {{--<li style="background: url('{{get_img_path('images/tegong/mn-9.png')}}');">--}}
                            {{--<a target="_blank" href="/goods?id=28209" class="tg-btn-right"></a>--}}
                            {{--<a target="_blank" href="/goods?id=28209" class="img-btn-right"></a>--}}
                        {{--</li>--}}
                        <li style="background: url('{{get_img_path('images/tegong/mn-3.png')}}');">
                            <a target="_blank" href="/goods?id=28214" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=28214" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/nm-6.png')}}');">
                            <a target="_blank" href="/goods?id=28207" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=28207" class="img-btn-right"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/mn-5.png')}}');">
                            <a target="_blank" href="/goods?id=28206" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=28206" class="img-btn-left"></a>
                        </li>
                    </ul>
                </div>

            </div>
            <div id="dr">
                <div class="dr-top" style="background: url('{{get_img_path('images/tegong/tg-drt.png')}}');width: 1200px;height: 240px;">
                    <a target="_blank" href="{{route('category.index',['step'=>'drt'])}}"></a>
                </div>

                <div class="dr-content">
                    <ul>
                        <li style="background: url('{{get_img_path('images/tegong/dr-1.png')}}');">
                            <a target="_blank" href="/goods?id=27818" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=27818" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/dr-2.png')}}');">
                            <a target="_blank" href="/goods?id=27846" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=27846" class="img-btn-right"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/dr-3.png')}}');">
                            <a target="_blank" href="/goods?id=28978" class="tg-btn-left"></a>
                            <a target="_blank" href="/goods?id=28978" class="img-btn-left"></a>
                        </li>
                        <li style="background: url('{{get_img_path('images/tegong/dr-4.png')}}');">
                            <a target="_blank" href="/goods?id=27837" class="tg-btn-right"></a>
                            <a target="_blank" href="/goods?id=27837" class="img-btn-right"></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    @include('common.footer')
    <script type="text/javascript">
        window.onscroll = function () {
            var t = document.documentElement.scrollTop || document.body.scrollTop;
            if(t>480){
                $('.tg-nav').addClass('fixnav')
                $('.nav-before').hide();
                $('.nav-after').hide();
                $('.nav-zq,.nav-mn,.nav-drt').css({
                    'margin-left':'0px',
                    'width':'140px',
                    'transition':'.2s all linear'
                })
                $('.kuang').css('box-shadow','0px 3px 16px rgba(0,0,0,0.2)');

            }
            else if(t<=480){
                $('.tg-nav').removeClass('fixnav')
                $('.nav-zq,.nav-mn,.nav-drt').css({
                    'margin-left':'37px',
                    'width':'105px'
                })
                $('.nav-before').show();
                $('.nav-after').show();
                $('.kuang').css('box-shadow','0px 0px 0px rgba(0,0,0,0.2)')
            }
            if(630<t&&t<=1450){
                $('.nav-zq').addClass('on')
            }else{
                $('.nav-zq').removeClass('on')
            }
            if(1450<t&&t<=3220){
                $('.nav-mn').addClass('on')
            }else{
                $('.nav-mn').removeClass('on')
            }
            if(3220<t&&t<=4000){
                $('.nav-drt').addClass('on')
            }else{
                $('.nav-drt').removeClass('on')
            }

        }
        $(function(){
            /*导航跳转效果插件*/
            $('.tg-nav').singlePageNav({
                offset:0
            });
            /*小屏幕导航点击关闭菜单*/


        })
    </script>
@endsection
