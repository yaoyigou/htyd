<div class="fixsearch">
    <div class="fixsearch-box">
        <img src="{{path('images/index/fixed_logo.jpg')}}" style="float: left;"/>
        <div class="fixedsearch_box fn_clear">
            <input style="padding-left: 10px;" id="fixed-suggest" name="userSearch" type="text" value="药品名称(拼音缩写)或厂家名称"
                   class="search_input1 suggest1"/>
            <button type="button" class="btn fixed-search_btn" id="" value="">搜 索</button>
            <div id="fixed-suggestions_wrap" class="search_show list_box suggestions_wrap" style="display: none;">

                <ul class="search_list suggestions" id="fixed-suggestions">

                </ul>
            </div>

        </div>
        <a href="http://www.hezongyy.com/cart">
            <div class="fixed-gouwuche">
                <img src="{{path('images/index/gouwuche.png')}}"/> 购物车
                <span style="color: red;">(0)</span>
            </div>
        </a>

        <a href="{{route('order.index')}}">
            <div class="fixed-dingdan">
                <img src="{{path('images/index/order.png')}}"/> 订单查询
            </div>
        </a>

    </div>

</div>