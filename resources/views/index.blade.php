@extends('layouts.app')
@section('content')
    <div class="slide_box">
        <div class="banner2">
            <ul class="banner-ctrl" style="width: {{count($ad121)*62}}px">
                @foreach($ad121 as $k=>$ad)
                    <li @if($k==0) class="current" @endif>
                        <span class="bg"></span>
                        <div class="ctrl-dot">
                            <i @if($k==0) class="on" @endif></i>
                        </div>
                        <div class="title-item">
                            <span class="title-bg"></span>
                            <div class="title-list">
                                <p><i></i></p>
                            </div>
                        </div>
                        <h4>{{str_replace('2017','',$ad->ad_name)}}</h4>
                    </li>
                @endforeach
            </ul>
            <a class="banner-btn banner-prev" href="javascript:void(0);"></a>
            <a class="banner-btn banner-next" href="javascript:void(0);"></a>
            <div class="banner-pic">
                @foreach($ad121 as $k=>$ad)
                    <ul>
                        <li style="background:#{{$ad->ad_bgc}}; @if($k==0) display:list-item; @endif">
                            <a onClick="_hmt.push(['_trackEvent','首页焦点图1','浏览','{{str_replace('2017','',$ad->ad_name)}}'])"
                               href="{{$ad->ad_link}}" title="" target="_blank" style="position:relative;">
                                <img data-src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}"
                                     src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}" height="480"
                                     width="780" alt=" "/>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>

        </div>
        <div style="width: 1200px;margin: 0 auto;">
            <div class="slide_right">
                @foreach($ad123 as $k=>$v)
                    @if($k<2)
                        <a href="{{$v->ad_link}}" @if($k==0) class="first_a" @endif>
                            <img src="{{$v->ad_code}}"/>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div id="container">
        <div class="container-box">
            @foreach($floors as $k=>$v)
                <div class="chanpintuijian" id="demo{{$k}}">
                    <div class="content_title">
                        <div class="shaixuan">
                            @foreach($v->child as $v1)
                                <li @if($loop->first) class="on" @endif>{{$v1->cat_name}}@if(!$loop->last)<img
                                            src="{{path('images/shu.jpg')}}"/>@endif</li>
                            @endforeach
                        </div>
                        <img src="{{path('images/title_left.jpg')}}"/><span>1F</span><img
                                src="{{path('images/title_right.jpg')}}"/><span>{{$v->cat_name}}</span>
                    </div>
                    <div class="wrapper1">
                        <div id="focus{{$k+1}}" class="focus">
                            <ul style="height: 400px;">
                                @foreach($v->ad1 as $v1)
                                    <li>
                                        <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="img_box">
                            <ul>
                                @foreach($v->ad2 as $v1)
                                    <li>
                                        <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <ul class="Allul">
                        @foreach($v->ad3 as $v1)
                            <li>
                                <a target="_blank" href="{{$v1->ad_link}}"><img src="{{$v1->ad_code}}"/></a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="content_bot">
                        <a href="{{$v->ad4->ad_link}}"><img src="{{$v->ad4->ad_code}}"/></a>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- app扫描结束 -->
        <!-- 弹出层结束 -->
        <!--尾部-->
        <div class="site-footer"
             style="border-top: 1px solid #ebebeb;position: relative;background: white;overflow: hidden;">
            <ul class="secondul" style="width: 1200px;margin: 0 auto;position: relative;">
                <li>

                    <ul>
                        <a href="#">
                            <li class="footer_title">新手指南</li>
                        </a>
                        <a href="#">
                            <li>常见问题</li>
                        </a>
                        <a href="#">
                            <li>新会员注册</li>
                        </a>
                        <a href="#">
                            <li>用户登录</li>
                        </a>
                        <a href="#">
                            <li>找回密码</li>
                        </a>
                    </ul>
                </li>

                <li>

                    <ul>
                        <a href="#">
                            <li class="footer_title">购物指南</li>
                        </a>
                        <a href="#">
                            <li>购物流程</li>
                        </a>
                        <a href="#">
                            <li>订单状态说明</li>
                        </a>
                        <a href="#">
                            <li>隐私声明</li>
                        </a>
                        <a href="#">
                            <li>发票制度</li>
                        </a>
                    </ul>
                </li>
                <li>

                    <ul>
                        <a href="#">
                            <li class="footer_title">配送服务</li>
                        </a>
                        <a href="#">
                            <li>方式、时间及费用</li>
                        </a>
                        <a href="#">
                            <li>商品验货及签收</li>
                        </a>
                    </ul>

                </li>
                <li>

                    <ul>
                        <a href="#">
                            <li class="footer_title">支付方式</li>
                        </a>
                        <a href="#">
                            <li>货到付款</li>
                        </a>
                        <a href="#">
                            <li>网上支付</li>
                        </a>
                        <a href="#">
                            <li>银行转账</li>
                        </a>
                        <a href="#">
                            <li>优惠券使用指南</li>
                        </a>

                    </ul>

                </li>
                <li style="border-right: 1px solid #e5e5e5;">

                    <ul>
                        <a href="#">
                            <li class="footer_title">售后服务</li>
                        </a>
                        <a href="#">
                            <li>退换货政策</li>
                        </a>
                        <a href="#">
                            <li>退换货流程</li>
                        </a>
                        <a href="#">
                            <li>退款方式及时效</li>
                        </a>
                        <a href="#">
                            <li>售后常见问题</li>
                        </a>
                        <a href="#">
                            <li>正品保障</li>
                        </a>
                    </ul>
                </li>
                <li class="erweima">
                    <p class="title">关注微信</p>
                    <div class="img_box">
                        二维码
                    </div>
                    <p class="tishi">及时了解最新活动信息</p>
                </li>
            </ul>

            <!--尾部-->
            <div class="dibu">
                <!--<p>互联网药品交易服务资格证：
                <a href="/images/zgz1.jpg" target="_blank" style="color: #323333">川B20130002</a> | 互联网药品信息服务资格证：
                <a href="/images/zgz2.jpg" target="_blank" style="color: #323333">川20150030</a>
            </p>
            <p>&copy 2014-2017
                <a href="/" target="_blank" style="color: #323333">合纵医药网-药易购</a>版权所有 ICP备案证书号：
                <a href="#" style="color: #323333">蜀ICP备14007234号01</a>
            </p>
            <p>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
            <ul style="height: 41px;">
                <li>
                    <a target="_blank" href="https://v.pinpaibao.com.cn/cert/site/?site=www.hezongyy.com&at=realname">
                        <img src="http://www.hezongyy.com/new/images/shiming_11.png?20170502" />
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="http://www.hezongyy.com/new/images/beian_11.png?20170502" />
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://credit.cecdc.com/CX20150626010878010620.html">
                        <img src="http://www.hezongyy.com/new/images/chengxin_11.png?20170502" />
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="http://www.hezongyy.com/new/images/360_11.png?20170502" />
                    </a>
                </li>
            </ul>-->
                <div class="left">
                    <ul>
                        <li>
                            <a href="#">关于我们</a> |
                            <a href="#资质证书">资质证书</a> |
                            <a href="#">资质证书</a> |
                            <a href="#">加入我们</a> |
                            <a href="#">法律声明</a>
                        </li>
                        <li class="left_li2">Copyright© 2017
                            <a href="#">www.htyd.com 浩天于达</a> 版权所有
                        </li>
                        <li class="left_li2">ICP备案证书号：
                            <a href="#">蜀ICP备140</a>
                        </li>
                    </ul>
                </div>
                <div class="right">
                    <ul>
                        <li>
                            <a target="_blank"
                               href="https://v.pinpaibao.com.cn/cert/site/?site=www.hezongyy.com&at=realname">
                                <img src="http://www.hezongyy.com/new/images/shiming_11.png?20170502"/>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://www.hezongyy.com/new/images/beian_11.png?20170502"/>
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="https://credit.cecdc.com/CX20150626010878010620.html">
                                <img src="http://www.hezongyy.com/new/images/chengxin_11.png?20170502"/>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="http://www.hezongyy.com/new/images/360_11.png?20170502"/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
