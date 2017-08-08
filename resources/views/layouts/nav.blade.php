<div id="nav">
    <div class="nav-box">
        <ul>
            <li class="fenlei">
                <a href="#" style="font-size:16px">
                    <img src="{{path('images/index/fenlei.png')}}"/> 全部商品分类
                </a>

            </li>
            @if($middle_nav)
                @foreach($middle_nav as $k=>$v)
                    <li class="li2"><a @if(isset($action)&&$v->id==$action)class="checked" @endif href="{{$v->url}}"
                                       @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>
                    </li>
                @endforeach
            @endif
            <li style="float: right;">
                <a href="javascript:;">
                    <img src="{{path('images/xiaoxi.png')}}" style="vertical-align:middle;">
                    <span style="vertical-align: middle;">公告：</span>
                    <span style="vertical-align: middle;color:#f52547;">该信息可以通过广告设置</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="site-content container">
        <div class="category-menu fn_clear" style="margin-top: -13px;*margin-top: -11px;">
            <ul class="category-list">
                @foreach($category as $v)
                    <li class="child-li">
                        <p>
                            <span class="img_box">
                                <img src="{{path('images/category/'.$v->template_file.'.png')}}" class="leftimg"/>
                                <img src="{{path('images/category/'.$v->template_file.'_1.png')}}" class="leftimg-1"/>
                            </span>
                            <a href="{{route('goods.index',['cat_id'=>$v->cat_id])}}"><span class="title_text">{{$v->cat_name}}</span></a>
                        </p>
                    </li>
                @endforeach
            </ul>

            <ul class="category-list-child fn_clear">
                @foreach($category as $v)
                    <li style="display: none;">
                        <div class="xiyao-box">
                            <div class="fn_clear content-xiyao">
                                @foreach($v->child as $v1)
                                    <a href="{{route('goods.index',['cat_id'=>$v1->cat_id])}}" title="{{$v1->cat_name}}">{{$v1->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>