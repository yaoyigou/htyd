@extends('layouts.app')
@push('header')
<link rel="stylesheet" type="text/css" href="{{path('css/log_reg_common.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/attach_left.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/help.css')}}"/>
@endpush
@section('content')
    @include('auth.header')
    <style>
        .subNavBox .subNav1 {
            height: 45px;
            line-height: 45px;
            font-size: 16px;
            font-weight: bolder;
            color: #393838;
            text-indent: 42px;
            border-bottom: 1px solid #E6E3E3;
        }
    </style>
    <div class="help_container fn_clear">
        <div class="main_left">
            @include('layouts.articleTree')
        </div>
        <div class="main_right">
            {!! $top_title or ''!!}
            <div class="content_box">
                <div class="bdsharebuttonbox" style="display: inline;float: right;">
                    {{--<a href="#" class="bds_more" data-cmd="more"></a>--}}
                    <a href="#" class="bds_weixin" data-cmd="weixin"></a>
                    <a href="#" class="bds_qzone" data-cmd="qzone"></a>
                    <a href="#" class="bds_tsina" data-cmd="tsina"></a>
                    <a href="#" class="bds_tqq" data-cmd="tqq"></a>
                    <a href="#" class="bds_renren" data-cmd="renren"></a>
                </div>
                <script>
                    window._bd_share_config = {
                        "common": {
                            "bdSnsKey": {},
                            "bdText": "",
                            "bdMini": "2",
                            "bdPic": "",
                            "bdStyle": "0",
                            "bdSize": "16"
                        },
                        "share": {},
                        "image": {
                            "viewList": ["qzone", "tsina", "tqq", "renren", "weixin"],
                            "viewText": "分享到：",
                            "viewSize": "16"
                        },
                        "selectShare": {
                            "bdContainerClass": null,
                            "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]
                        }
                    };
                    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
                </script>
                <h4>{{$info->title}}</h4>
                <p>@if($info->content!='')
                        {!! $info->content !!}
                    @endif</p>

            </div>

        </div>
    </div>
    @include('auth.footer')
@endsection
