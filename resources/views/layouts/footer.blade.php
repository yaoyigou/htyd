<div class="site-footer" style="border-top: 1px solid #ebebeb;position: relative;background: white;overflow: hidden;">
    <ul class="secondul" style="width: 1200px;margin: 0 auto;position: relative;">
        @foreach($article_cat as $v)
            <li @if($loop->last) style="border-right: 1px solid #e5e5e5;" @endif>
                <ul>
                    <a href="{{route('article.index',['cat_id'=>$v->cat_id])}}">
                        <li class="footer_title">{{$v->cat_name}}</li>
                    </a>
                    @foreach($v->article as $v1)
                        <a href="{{route('article.show',['id'=>$v->article_id])}}">
                            <li>{{$v->title}}</li>
                        </a>
                    @endforeach
                </ul>
            </li>
        @endforeach
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
        <div class="left">
            <ul>
                <li>
                    @foreach($nav_bottom as $v)
                        <a href="{{$v->url}}">{{$v->name}}</a>@if(!$loop->last) |@endif
                    @endforeach
                </li>
                <li class="left_li2">Copyright© {{date('Y')}}
                    <a href="{{shop_config('domain_name')}}">{{shop_config('domain_name')}} {{shop_config('web_name')}}</a>
                    版权所有
                </li>
                <li class="left_li2">ICP备案证书号：
                    <a href="javascript:;">{{shop_config('icp_number')}}</a>
                </li>
            </ul>
        </div>
        <div class="right">
            <ul>
                <li>
                    <a target="_blank" href="https://v.pinpaibao.com.cn/cert/site/?site=www.hezongyy.com&at=realname">
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