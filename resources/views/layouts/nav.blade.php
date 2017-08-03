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
                            <a href="#"><span class="title_text">{{$v->cat_name}}</span></a>
                        </p>
                    </li>
                @endforeach
            </ul>

            <ul class="category-list-child fn_clear" style="padding-bottom: 30px">
                @foreach($category as $v)
                    <li style="display: none;">
                        <div class="xiyao-box">
                            <div class="fn_clear content-xiyao">
                                @foreach($v->child as $v1)
                                    <a href="#" target="_blank" title="{{$v1->cat_name}}">{{$v1->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>