@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new/cuxiao.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #cuxiao {
            width: 100%;
            min-width: 1200px;
            background: url('{{get_img_path('images/new/cuxiao-bg.jpg')}}') no-repeat scroll top center;
        }

        .mp_tooltip {
            top: 0 !important;
        }

        .secondul li {
            position: static;
        }
    </style>
    <script src="{{path('js/new/cuxiaozhuanqu.js')}}" type="text/javascript" charset="utf-8"></script>

@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div id="cuxiao">
        <div class="cuxiao-box">
            <div class="tg-nav">
                <div class="tg-nav-box" style="width: {{count($menu)*150}}px;">
                    @foreach($menu as $v)
                        <a href="#{{$v->ad_link}}" class="nav-{{$v->ad_link}}">
                            <div class="nav-before before"></div>
                            {{$v->ad_name}}
                            <div class="nav-after after"></div>
                        </a>
                    @endforeach
                    <div class="kuang" style="width: {{count($menu)*150}};"></div>
                </div>
            </div>
            <!--每周精选版块开始-->

            <div id="mrjx">
                @if(count($mzjx)>0)
                    <img src="{{get_img_path('images/new/top-time.png')}}"/>
                    <!--倒计时-->
                    <div class="meizhou-remaintime" time="{{$mzjx->time}}">
                        <span class="meizhou-day"></span>
                        <span class="meizhou-hourse"></span>
                        <span class="meizhou-minute"></span>
                        <span class="meizhou-secound"></span>
                    </div>
                    <!--倒计时-->
                    <div class="top-time-content">
                        <ul>
                            @foreach($mzjx as $v)
                                <li>
                                    <div class="img-box">
                                        <a target="_blank" href="{{$v->goods_url}}"><img
                                                    style="width: 100%;height: 100%"
                                                    src="{{$v->goods_thumb}}"/></a>
                                    </div>
                                    <div class="img-box-content">
                                        <span>{{str_limit($v->goods_name,20)}}</span>
                                        <span>{{$v->spgg}}</span>
                                        <span>{{str_limit($v->sccj,28)}}</span>
                                        <span class="meiri-img">
										<img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                            {{$v->real_price}}
									</span>
                                        <a target="_blank" href="{{$v->goods_url}}">
                                            <div>点击抢购</div>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!--每周精选版块结束-->
            <!--限时特价开始-->

            <div id="xstj">
                @if(count($xstj)>0)
                    <img src="{{get_img_path('images/new/xianshi.png')}}"/>
                    <!--倒计时-->
                    <div class="xianshi-remaintime" time="100000">
                        <span class="xianshi-day"></span>
                        <span class="xianshi-hourse"></span>
                        <span class="xianshi-minute"></span>
                        <span class="xianshi-secound"></span>
                    </div>
                    <!--倒计时-->
                    <div class="xstj-content">
                        <ul>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div>10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xstj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                        <span>￥8.71</span>
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="readmore">
                        <div class="readmore-box">
							<span class="readmore-1">
								点击查看全部特价商品
							</span>
                            <span class="readmore-2">
								点击查看全部特价商品
							</span>
                        </div>
                    </a>
                @endif
            </div>

            <!--限时特价结束-->
            <!--爆品秒杀开始-->
            <div id="bpms">
                @if(count($bpms)>0)
                    <img src="{{get_img_path('images/new/bpms.jpg')}}"/>
                    <div class="shuoming">
                        <img src="{{get_img_path('images/new/shuoming.jpg')}}"/>
                        <div>秒杀商品只有在秒杀活动页加入购物车才能享受秒杀价格，活动开始后即可加入购物车。</div>
                    </div>
                    <div class="shijian">
                        <img src="{{get_img_path('images/new/shijian.jpg')}}"/>
                        <div>2017年4月12日 “09:00”、”14:00“、”16:00“三场秒杀</div>
                    </div>
                    <div class="changci">
                        <img src="{{get_img_path('images/new/changci.png')}}"/>
                    </div>
                    <ul>
                        <li>
                            <div class="bpms-imgbox">
                                <a href="#"><img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/></a>
                                <div class="bpms-imgbox-text">
                                    <span>川贝止嗽合剂</span><br/>
                                    <span>10ml*10支(玻璃管)</span>
                                </div>
                            </div>
                            <div class="bpms-content">
                                <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                <span class="bpms-content-1">7.26</span><span class="bpms-content-2">￥8.71</span>
                                <div class="bpms-kucun">
                                    剩余库存:<span>500</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="bpms-imgbox">
                                <a href="#"><img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/></a>
                                <div class="bpms-imgbox-text">
                                    <span>川贝止嗽合剂</span><br/>
                                    <span>10ml*10支(玻璃管)</span>
                                </div>
                            </div>
                            <div class="bpms-content">
                                <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                <span class="bpms-content-1">7.26</span><span class="bpms-content-2">￥8.71</span>
                                <div class="bpms-kucun">
                                    剩余库存:<span>500</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="bpms-imgbox">
                                <a href="#"><img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/></a>
                                <div class="bpms-imgbox-text">
                                    <span>川贝止嗽合剂</span><br/>
                                    <span>10ml*10支(玻璃管)</span>
                                </div>
                            </div>
                            <div class="bpms-content">
                                <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                <span class="bpms-content-1">7.26</span><span class="bpms-content-2">￥8.71</span>
                                <div class="bpms-kucun">
                                    剩余库存:<span>500</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="bpms-imgbox">
                                <a href="#"><img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/></a>
                                <div class="bpms-imgbox-text">
                                    <span>川贝止嗽合剂</span><br/>
                                    <span>10ml*10支(玻璃管)</span>
                                </div>
                            </div>
                            <div class="bpms-content">
                                <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                <span class="bpms-content-1">7.26</span><span class="bpms-content-2">￥8.71</span>
                                <div class="bpms-kucun">
                                    剩余库存:<span>500</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="bpms-imgbox">
                                <a href="#"><img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/></a>
                                <div class="bpms-imgbox-text">
                                    <span>川贝止嗽合剂</span><br/>
                                    <span>10ml*10支(玻璃管)</span>
                                </div>
                            </div>
                            <div class="bpms-content">
                                <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                <span class="bpms-content-1">7.26</span><span class="bpms-content-2">￥8.71</span>
                                <div class="bpms-kucun">
                                    剩余库存:<span>500</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a href="#" class="readmore">
                        <div class="readmore-box">
							<span class="readmore-1">
								点击进入秒杀页
							</span>
                            <span class="readmore-2">
								点击进入秒杀页
							</span>
                        </div>
                    </a>
                @endif
            </div>
            <!--爆品秒杀结束-->
            <!--消费满减开始-->
            <div id="xfmj">
                @if(count($xfmj)>0)
                    <img src="{{get_img_path('images/new/xfmj.jpg')}}"/>
                    <div class="xfmj-remaintime" time="10000">
                        <span class="xfmj-hourse"></span>
                        <span class="xfmj-minute"></span>
                        <span class="xfmj-secound"></span>
                    </div>
                    <div class="xfmj-jieshao">
                        <span>以下商品参与消费1000减50元活动。</span>
                    </div>
                    <div class="xfmj-content">
                        <ul>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xfmj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xfmj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xfmj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="img-box">
                                    <a href="#"><img src="{{get_img_path('images/new/xs-chanpin.jpg')}}"/></a>
                                    <div class="mz">
                                        川贝止嗽合剂
                                        <hr/>
                                    </div>
                                </div>
                                <div class="xq">
                                    <div class="ml">10ml*10支(玻璃管)</div>
                                    <div>天津和治药业有限公司</div>
                                    <div class="xfmj-jiage">
                                        <img src="{{get_img_path('images/new/meiri-tubiao.png')}}"/>
                                        7.26
                                    </div>
                                    <a href="#">
                                        点击抢购
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="readmore">
                            <div class="readmore-box">
							<span class="readmore-1">
								点击查看全部消费满减商品
							</span>
                                <span class="readmore-2">
								点击查看全部消费满减商品
							</span>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            <!--消费满减结束-->
            <!--超值换购开始-->
            <div id="czhg">
                @if(count($czhg)>0)
                    <img src="{{get_img_path('images/new/czhg.jpg')}}"/>
                    <div class="czhg-content">
                        <ul>
                            @foreach($czhg as $v)
                                <li>
                                    <div class="img-box">
                                        <a target="_blank" href="{{$v->goods_url}}"><img
                                                    style="width: 100%;height: 240px;" src="{{$v->goods_thumb}}"/></a>
                                        <div class="mz">
                                            {{$v->goods_name}}
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="xq">
                                        <div class="ml">{{$v->spgg}}</div>
                                        <div>{{str_limit($v->sccj,28)}}</div>
                                        <div class="czhg-jiage">
                                            <p class="huodong">活动</p>
                                            {{--<span class="jiage-content">单次购买满10盒<span>+0.1元</span>可换购本品1盒</span>--}}
                                            <span class="jiage-content">{!! str_replace('+','<span>+',str_replace('元','元</span>',str_limit($v->cxxx,56))) !!}</span>
                                        </div>
                                        <a target="_blank" href="{{$v->goods_url}}">
                                            点击抢购
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a target="_blank" href="/cxhd/czhg" class="readmore">
                            <div class="readmore-box">
								<span class="readmore-1">
									点击查看全部换购商品
								</span>
                                <span class="readmore-2">
									点击查看全部换购商品
								</span>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            <!--超值换购结束-->
            <!--精品买赠开始-->
            <div id="jpmz">
                @if(count($jpmz)>0)
                    <img src="{{get_img_path('images/new/jpmz.jpg')}}"/>
                    <div class="jpmz-content">
                        <ul>
                            @foreach($jpmz as $v)
                                <li>
                                    <div class="img-box">
                                        <a target="_blank" href="{{$v->goods_url}}"><img
                                                    style="width: 100%;height: 240px;" src="{{$v->goods_thumb}}"/></a>
                                        <div class="mz">
                                            {{$v->goods_name}}
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="xq">
                                        <div class="ml">{{$v->spgg}}</div>
                                        <div>{{str_limit($v->sccj,28)}}</div>
                                        <div class="czhg-jiage">
                                            <p class="huodong">活动</p>
                                            <span class="jiage-content">{{$v->cxxx}}</span>
                                        </div>
                                        <a target="_blank" href="{{$v->goods_url}}">
                                            点击抢购
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a target="_blank" href="/cxhd/jpmz" class="readmore">
                            <div class="readmore-box">
								<span class="readmore-1">
									点击查看全部买赠商品
								</span>
                                <span class="readmore-2">
									点击查看全部买赠商品
								</span>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            <!--精品买赠结束-->
            <!--厂家促销开始-->
            <div id="cjcx">
                @if(count($cjcx)>0)
                    <img src="{{get_img_path('images/new/cjcx.jpg')}}"/>
                    <div class="content1-title">
                        感冒灵颗粒
                    </div>
                    <div class="content2-title">
                        注射用头孢
                    </div>
                    <div class="cjcx-content1">
                        <div class="cjcx-content1-box">
                            <img src="{{get_img_path('images/new/cjcx-top.png')}}"/>
                            <img src="{{get_img_path('images/new/cjcx-img.jpg')}}"/>
                            <a href="#">点击我我我</a>
                        </div>
                    </div>
                    <div class="cjcx-content2">
                        <div class="cjcx-content2-box">
                            <img src="{{get_img_path('images/new/cjcx-top.png')}}"/>
                            <img src="{{get_img_path('images/new/bpms-chanpin.jpg')}}"/>
                            <a href="#">点击我我我</a>
                        </div>
                    </div>
                @endif
            </div>
            <!--厂家促销结束-->
            <!--效期品种开始-->
            <div id="xqpz">
                @if(count($xqpz)>0)
                    <img src="{{get_img_path('images/new/xqpz.jpg')}}"/>
                    <img src="{{get_img_path('images/new/xqpz-img.jpg')}}" class="warning"/>
                    <div class="xqpz-content">
                        <ul>
                            @foreach($xqpz as $v)
                                <li>
                                    <div class="img-box">
                                        <a target="_blank" href="{{$v->goods_url}}"><img
                                                    style="width: 100%;height: 240px;" src="{{$v->goods_thumb}}"/></a>
                                        <div class="mz">
                                            {{$v->goods_name}}
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="xq">
                                        <div class="ml">{{$v->spgg}}</div>
                                        <div>{{str_limit($v->sccj,28)}}</div>
                                        <div class="czhg-jiage">
                                            <p class="huodong">活动</p>
                                            <span class="jiage-content">此商品的有效期到<span>{{$v->xq}}</span>止</span>
                                        </div>
                                        <a target="_blank" href="{{$v->goods_url}}">
                                            点击抢购
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a target="_blank" href="{{route('category.index',['dis'=>7])}}" class="readmore">
                            <div class="readmore-box">
								<span class="readmore-1">
									点击查看全部效期商品
								</span>
                                <span class="readmore-2">
									点击查看全部效期商品
								</span>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            <!--效期品种结束-->
        </div>
    </div>

    @include('common.footer')

    <script>
        $(document).ready(function () {
            //每周精选时间
            var mzjx = '{{count($mzjx)}}';
            var xstj = '{{count($xstj)}}';
            var xfmj = '{{count($xfmj)}}';

            if (mzjx > 0) {
                var mzjx_time = parseInt($('.meizhou-remaintime').attr('time'));
                window.setInterval(function () {
                    mzjx_time--;
                    var second = Math.floor(mzjx_time % 60);             // 计算秒
                    var minite = Math.floor((mzjx_time / 60) % 60);      //计算分
                    var hour = Math.floor((mzjx_time / 3600) % 24);      //计算小时
                    var day = Math.floor((mzjx_time / 3600) / 24);       //天
                    $('.meizhou-remaintime').html('<span class="meizhou-day">' + day + '</span>' + '<span class="meizhou-hourse">' + hour + '</span>' + '<span class="meizhou-secound">' + second + '</span>' + '<span class="meizhou-minute">' + minite + '</span>');
                    if (mzjx_time < 1) {
                        mzjx_time = 1
                    }
                }, 1000);
            }
            if (xstj > 0) {
                var xstj_time = parseInt($('.xianshi-remaintime').attr(time));
                window.setInterval(function () {
                    xstj_time--;
                    var second = Math.floor(xstj_time % 60);             // 计算秒
                    var minite = Math.floor((xstj_time / 60) % 60);      //计算分
                    var hour = Math.floor((xstj_time / 3600) % 24);      //计算小时
                    var day = Math.floor((xstj_time / 3600) / 24);       //天
                    $('.xianshi-remaintime').html('<span class="xianshi-day">' + day + '</span>' + '<span class="xianshi-hourse">' + hour + '</span>' + '<span class="xianshi-secound">' + second + '</span>' + '<span class="xianshi-minute">' + minite + '</span>');
                    if (xstj_time < 1) {
                        xstj_time = 1
                    }
                }, 1000);
            }
            if (xfmj > 0) {
                var xfmj_time = parseInt($('.xfmj-remaintime').attr(time));
                window.setInterval(function () {
                    xfmj_time--;
                    var second = Math.floor(xfmj_time % 60);             // 计算秒
                    var minite = Math.floor((xfmj_time / 60) % 60);      //计算分
                    var hour = Math.floor((xfmj_time / 3600) % 24);      //计算小时
                    var day = Math.floor((xfmj_time / 3600) / 24);       //天
                    $('.xfmj-remaintime').html('<span class="xfmj-hourse">' + hour + '</span>' + '<span class="xfmj-secound">' + second + '</span>' + '<span class="xfmj-minute">' + minite + '</span>');
                    if (xfmj_time < 1) {
                        xfmj_time = 1
                    }
                }, 1000);
            }
        })
    </script>
@endsection
