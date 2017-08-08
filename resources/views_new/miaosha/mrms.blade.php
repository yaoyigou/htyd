@extends('common.index')
@section('links')
    <style>
        body, ul, li, ol, img, p, a {
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: "microsoft yahei";
            list-style: none;
            outline: none;
            text-decoration: none;
        }

        img {
            vertical-align: middle;
            border: none;
        }

        #miaosha-top {
            width: 100%;
            height: 519px;
            background: url('{{get_img_path('images/miaosha/miaosha_top.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            overflow: hidden;

        }

        .remaitime {
            position: relative;
            width: 640px;
            height: 60px;
            margin: 420px auto;
            font-size: 16px;
            color: #890211;
            background: url('{{get_img_path('images/miaosha/remiantime_box.jpg')}}') no-repeat;
            overflow: hidden;
        }

        .zhuangtai-text-1,
        .zhuangtai-text-2 {
            float: left;
            font-size: 16px;
            color: #333;
            height: 34px;
            line-height: 34px;
            margin: 13px 0 0 285px;
        }

        .zhuangtai-text-2 {
            display: none;
        }

        .time-before,
        .time-after {
            width: 168px;
            height: 34px;
            line-height: 34px;
            float: right;
            margin: 13px 59px 0 0;
        }

        .time-after {
            display: none;
        }

        .hour,
        .minute,
        .second {
            display: inline-block;
            width: 36px;
            height: 34px;
            line-height: 34px;
            text-align: center;
            font-size: 24px;
            color: white;
            /*border: 1px solid red;*/
        }

        .minute, .second {
            margin-left: 29px;
        }

        #miaosha-bottom {
            width: 100%;
            min-height: 240px;
            background: #8415df;
            min-width: 1200px;
            padding-bottom: 160px;
            background: url('{{get_img_path('images/miaosha/miaosha_bottom.jpg')}}') scroll top center;
        }

        .chanpin-box {
            width: 900px;
            margin: 0 auto;
        }

        .chanpin-box ul li {
            width: 900px;
            height: 240px;
            position: relative;
            /*margin: 0 auto;*/
            list-style: none;
            margin-top: 20px;
            background: white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .chanpin-box ul li:first-child {
            margin-top: 0;
        }

        .img_box {
            width: 218px;
            height: 218px;
            border: 1px solid #dddddd;
            margin: 10px 0 0 10px;
            overflow: hidden;
            float: left;
            position: relative;
        }

        .xinxi {
            float: left;
            /*border: 1px solid red;*/
            margin: 10px 0 0 30px;
            position: relative;
            width: 600px;
            height: 208px;
            overflow: hidden;
        }

        .xinxi p {
            margin-top: 5px;
        }

        .xinxi .name {
            color: #333333;
            font-size: 24px;
        }

        .xinxi .param, .xinxi .company {
            color: #999999;
            font-size: 16px;
        }

        .xinxi .xian {
            width: 600px;
            border-top: 1px dashed #cccccc;
            margin: 20px 0 15px 0;
            height: 1px;
        }

        .xinxi .liang {
            color: #666;
            font-size: 18px;
            font-weight: bold;
        }

        .xinxi .liang span {
            color: #ee2d2d;
        }

        .xinxi .kucun {
            color: #666;
            font-size: 18px;
            margin-top: 13px;
        }

        .xinxi .buy {
            width: 353px;
            height: 80px;
            line-height: 80px;
            text-align: center;
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .xinxi .buy .danjia {
            float: left;
            width: 194px;
            height: 78px;
            line-height: 78px;
            border: 1px solid #ed3d3d;
            border-right: none;
            font-size: 14px;
            color: #ff0000;
        }

        .xinxi .buy .danjia span:first-child {
            font-size: 30px;
            height: 78px;
            font-weight: bold;
        }

        .xinxi .buy .danjia span:first-child + span {
            color: #666;
            text-decoration: line-through;
            position: relative;
            top: -5px;
            margin-left: 5px;
        }

        .xinxi .buy .buy_now {
            float: left;
            width: 157px;
            height: 80px;
            background: #ed3d3d;
            color: #fff;
            font-size: 18px;
        }

        .xinxi .buy .sanjiao {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 0;
            height: 0;
            border-top: 20px solid transparent;
            border-right: 20px solid white;
        }

        .maiwan {
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .kaishi {
            display: block;
            background: rgb(153, 153, 153);
        }

        .goumai {
            display: none;
            background: #f55967;
        }

        .maiwan-btn {
            display: none;
            background: rgb(153, 153, 153);
        }
    </style>
    <!--[if lte IE 8]>
    <script src="{{path('20170412/js/PIE_IE678.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    <div id="miaosha-top">
        <div class="remaitime">
            <div class="zhuangtai-text-1" @if($ms_group->start>$now) style="display: block;"
                 @else style="display: none;" @endif>
                距离开始还有：
            </div>
            <div class="zhuangtai-text-2" @if($ms_group->start<=$now) style="display: block;"
                 @else style="display: none;" @endif>
                距离结束还有：
            </div>
            <div class="time-before" @if($ms_group->start>$now) style="display: block;"
                 @else style="display: none;" @endif>
                <span class="hour"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
            <div class="time-after" @if($ms_group->start<=$now) style="display: block;"
                 @else style="display: none;" @endif>
                <span class="hour"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
        </div>
    </div>
    <div id="miaosha-bottom">
        <div class="chanpin-box">
            <ul>
                @foreach($ms_group->ms_goods as $v)
                    <li id="{{$v->goods_id}}" @if(in_array($v->goods_id,$cart)) type="2" msg="商品已抢购" @else type="0"
                        msg="" @endif>
                        <div class="img_box">
                            <img style="width: 100%" src="{{$v->goods->goods_thumb}}"/>
                            <img src="{{get_img_path('images/miaosha/maiwan.png')}}" class="maiwan"
                                 @if($v->goods_number<=0) style="display: block" @else style="display: none" @endif/>
                        </div>
                        <div class="xinxi">
                            <p class="name">{{$v->goods->goods_name}}</p>
                            <p class="param">{{$v->goods->ypgg}}</p>
                            <p class="company">{{$v->goods->sccj}}</p>
                            <p class="xian"></p>
                            <p class="liang">固定抢购量：<span>{{$v->cart_number}}</span>{{$v->goods->dw or ''}}</p>
                            <p class="kucun">总量：<span
                                        id="goods_number{{$v->goods_id}}">{{$v->goods_number}}</span>{{$v->goods->dw or ''}}
                            </p>
                            <div class="buy">
                                <div class="danjia">
                                    ￥<span>{{$v->real_price}}</span>
                                    <span>￥{{$v->old_price}}</span>
                                </div>
                                <a onclick="add_to_redis('{{$v->goods_id}}')" class="buy_now">
                                    立即购买
                                </a>
                                <div class="sanjiao"></div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    {{--@include('miaosha.daohang')--}}
    <script type="text/javascript">
        $(function () {
            var start = '{{$ms_group->start}}'; //活动开始时间
            var now = '{{$now}}';  //当前时间
            var end = '{{$ms_group->end}}'; //活动结束时间
            var SysSecond = start - now;
            var jieshu = end - now;

            $(document).ready(function () {
                if (SysSecond > 0) {
                    before();
                    window.setInterval(before, 1000);
                }
                start1();
                window.setInterval(start1, 1000);
            });
            function before() {
                SysSecond--;
                if (SysSecond >= 0) {
                    var second = parseInt(SysSecond % 60);             // 计算秒
                    second = bushu(second);
                    var minute = parseInt((SysSecond / 60) % 60);      //计算分
                    minute = bushu(minute);
                    var hour = Math.floor((SysSecond / 3600));  //计算小时
                    hour = bushu(hour);
                    $('.time-before').html(
                        '<span class="hour">' + hour + '</span>' + '<span class="minute">' + minute + '</span>' + '<span class="second">' + second + '</span>'
                    )

                }

                if (SysSecond < 0) {
                    $('.time-before').hide();
                    $('.time-after').show();
                    $('.zhuangtai-text-1').hide();
                    $('.zhuangtai-text-2').css('display', 'inline-block');
                    $('.maiwan-btn').hide();
                    $('.kaishi').hide();
                    $('.goumai').show();
                }
            }

            function start1() {
                jieshu--;
                var second = parseInt(jieshu % 60);             // 计算秒
                second = bushu(second);
                var minute = parseInt((jieshu / 60) % 60);      //计算分
                minute = bushu(minute);
                var hour = Math.floor((jieshu / 3600));  //计算小时
                hour = bushu(hour);
                $('.time-after').html(
                    '<span class="hour">' + hour + '</span>' + '<span class="minute">' + minute + '</span>' + '<span class="second">' + second + '</span>'
                )
            }

        })
        function add_to_redis(id) {
            var type = $('#' + id).attr('type');
            if (type == 0) {
                $.ajax({
                    url: '/ms',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        if (data.error == 0 || data.error == 2) {
                            $('#goods_number' + id).text(data.kc);
                            layer.confirm(data.msg, {
                                btn: ['继续抢购', '去结算'], //按钮
                                icon: 1
                            }, function (index) {
                                layer.close(index);
                            }, function () {
                                location.href = '/cart';
                                return false;
                            });
                        } else if (data.error == 3) {
                            layer.confirm(data.msg, {
                                btn: ['注册', '登录'], //按钮
                                icon: 2
                            }, function () {
                                location.href = '/auth/register';
                            }, function () {
                                location.href = '/auth/login';
                                return false;
                            });
                        } else {
                            layer.alert(data.msg, {icon: 2})
                        }
                        if (data.error == 0) {
                            $('#' + id).attr('type', 2);
                            $('#' + id).attr('msg', '商品已抢购');
                        } else {
                            $('#' + id).attr('type', data.error);
                            $('#' + id).attr('msg', data.msg);
                        }
                    }
                })
            } else {
                var msg = $('#' + id).attr('msg');
                wxts(type, msg);
            }
        }

        function bushu(sz) {
            if (sz <= 9) {
                sz = '0' + sz;
            }
            return sz;
        }

        function wxts(type, msg) {
            if (type == 0 || type == 2) {
                layer.confirm(msg, {
                    btn: ['继续抢购', '去结算'], //按钮
                    icon: 1
                }, function (index) {
                    layer.close(index);
                }, function () {
                    location.href = '/cart';
                    return false;
                });
            } else if (type == 3) {
                layer.confirm(msg, {
                    btn: ['注册', '登录'], //按钮
                    icon: 2
                }, function () {
                    location.href = '/auth/register';
                }, function () {
                    location.href = '/auth/login';
                    return false;
                });
            } else {
                layer.alert(msg, {icon: 2})
            }
        }
    </script>
@endsection