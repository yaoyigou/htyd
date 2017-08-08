@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="{{path('js/ppzq.js')}}"></script>

    <style type="text/css">

        .pingpai-box{width: 100%;padding: 60px  0;}
        .pingpai-box .pingpai-list{width: 1200px;margin: 0 auto;overflow: hidden;}
        .pingpai-box .pingpai-list ul{width: 1400px;}
        .pingpai-box .pingpai-list ul li{position: relative;width: 260px;height: 375px;float: left;background-color: #f0f0f0;margin:0 54px 60px 0;}
        .pingpai-box .pingpai-list ul li  img{width: 260px;height: 375px;}


        .listPageDiv { height: 50px; line-height: 50px; text-align: right; margin-top: 10px; float: left; width: 100%;color: #333333;font-family: "Microsoft YaHei"}
        .pageList{width: 1000px;float: left;}
        .listPageDiv .p1 { border: 1px #CCC solid; padding: 4px 9px; margin: 3px; background-color: #efefef;}
        .listPageDiv .p_ok {color: #39a817; border: 0; background-color: #fff;}
        .listPageDiv a {color: #666;}
        .listPageDiv a:hover{text-decoration: underline;color: #39a817;}
        .listPageDiv .no{background-color: #fff;}
        .listPageDiv .no a{color: #cccccc;}
        .listPageDiv .page_inout{width: 24px;height: 24px;border: 1px solid #ccc;margin: 0 5px;line-height: 24px;text-align: center;}
        .listPageDiv .submit{cursor:pointer; width: 40px;height: 24px;line-height: 20px;background-color: #efefef;border: 1px solid #ccc;margin-right: 10px;}
        .listPageDiv .submit_input{padding-left: 10px;width: 180px;float: right;_margin-top: 10px;}

        .search-box{width:1200px;height:90px;margin:0 auto;border:1px solid #e5e5e5;margin-top:60px;}
        .search-box .r_top{height: 50px;line-height: 50px;color: #646464;position: relative;width: 985px;padding-left: 40px;font-size: 14px;}
        .search-box .r_top .filter_ico{position: absolute;width: 20px;height: 20px;left: 15px;top:15px; }

        .initial{height: 30px;line-height: 30px;margin-bottom: 15px;}
        .initial .title_name{padding-left: 25px;font-size: 14px;color: #646464;}
        .initial a{font-size: 14px;padding:3px 6px ;color: #646464;}
        .initial a:hover,.initial a.checked_a{background-color: #3ebb2b;color: #fff;}

        .search-box p{width: 400px;float: left;margin-left: 25px;}
        .search-box p input.text{width: 300px;height: 34px;line-height: 34px;border: 1px solid #e5e5e5;text-indent: 5px;}
        .search-box .submit{width: 100px;height: 36px;border-radius: 5px;background-color: #3ebb2b;color: #fff;line-height: 36px;text-align: center;cursor:pointer;float: left;font-size: 14px}
        .search-box p .title{color: #3ebb2b;font-size: 14px;}


        .g_right_bottom{padding: 10px 0 10px 0;font-size: 13px;background-color: #fffdee;text-indent: 50px;font-weight: bold}
        .g_right_bottom p{line-height: 20px}
        .g_right_bottom p span{color: red;font-weight: normal;font-size: 12px}
        .g_right_bottom a{text-decoration: none;color: #3ebb2b;font-size: 12px;}

        .g_right_bottom_bottom{margin-top: 20px;border-top: 1px solid #ccc;padding-top: 10px;padding-left: 20px}
        .g_right_bottom_bottom p a{color: red;text-decoration: none}
        .search-box a:hover{text-decoration: underline;}
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    @if($ad117)
        <div class="pingpaizq"  style="background: url('{{$ad117->ad_code}}') no-repeat scroll center top;height: 400px;min-width: 1200px;overflow: hidden;width: 100%;">

        </div>
    @endif



    <div class="search-box" >
        <div style="height:55px;margin-top:25px;position: relative;" class="fn_clear" >
            <p>
                <span class="title">生产厂家：</span>
                <input type="text" name="userSearch" value="{{$ppzq_key or ''}}" class="text" id="product_name">
                <a href="/ppzq" style="position:absolute;right:20px;top:10px;color:#3ebb2b;width:62px;height:24px;">返回主页面</a>

            </p>
            <div id="list_wrap" class="search_show list_box suggestions_wrap" style="display: none;left: 98px;top: 35px;width: 294px;border: 1px solid #e5e5e5">
                <ul class="search_list suggestions" id="list" style="width: 270px;">

                </ul>
            </div>
            <input type="submit" class="submit" value="查　询" id="ss_btn">
        </div>




    </div>



    <div class="pingpai-box">
        <div class="pingpai-list">
            @if(count($pages)>0)
            <ul class="list-first fn_clear" >
                @foreach($pages as $v)
                <li>
                    <a href="@if(!empty($v->url)) {{$v->url}} @else {{route('category.index',['step'=>$v->rec_id,'showi'=>0])}} @endif" target="_blank"><img src="{{$v->img}}" alt="" /></a>
                </li>
                @endforeach
            </ul>

            <!--分页显示开始-->
            @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                'url'=>'ppzq.list',
                'ppzq_key'=>'{{$ppzq_key}}',

                ]) !!}
                @endif
                        <!--分页显示结束-->
            @else
                    <div class="g_right_bottom" style="padding: 10px 0 10px 0;
font-size: 13px;
background-color: #fffdee;
text-indent: 50px;
font-weight: bold;">
                        <p>抱歉, 没有找到
                            与<span>{{$ppzq_key or ''}}</span>
                            相关的药品,</p>
                    </div>
            @endif
        </div>


    </div>

    @include('common.footer')

@endsection
