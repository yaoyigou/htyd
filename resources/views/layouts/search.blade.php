<div class="search" style="position: relative;*z-index: 9999;">
    <div class="search_box">
        <div>
            <a href="{{route('index')}}" style="display: inline-block;height: 64px;position: relative;">
                <img style="position: absolute;" src="{{path('images/index/logo.jpg')}}"/>
            </a>
            <div class="search_box fn_clear">
                <input id="suggest" name="userSearch" type="text" value="药品名称(拼音缩写)或厂家名称" class="search_input suggest"/>
                <a href="javascript:void(0)" class="btn search_btn">搜 索</a>

                <div id="suggestions_wrap" class="search_show list_box suggestions_wrap"
                     style="margin-left: 330px;margin-top: -46px;left:auto;top: auto;*margin-left: -503px;display: none;">

                    <ul class="search_list suggestions" id="suggestions">

                    </ul>
                </div>
            </div>

            <a href="{{route('cart.index')}}">
                <div class="gouwuche" style="float: right;">
                    <img style="margin-top: -5px;" src="{{path('images/index/gouwuche.png')}}"/> 购物车
                    <span style="color: red;">({{cart_num()}})</span>
                </div>
            </a>

            <a href="{{route('order.index')}}">
                <div class="dingdan" style="float: right;">
                    <img src="{{path('images/index/order.png')}}"/> 订单查询
                </div>
            </a>

            <div class="cuxiao">
                @if(count($ad159)>0)
                    @foreach($ad159 as $v)
                        <a target="_blank" href="{{$v->ad_link}}">{{$v->ad_name}}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>