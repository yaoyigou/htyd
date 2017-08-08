@extends('layouts.app')
@push('header')
<link rel="stylesheet" type="text/css" href="{{path('css/log_reg_common.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/attach_left.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{path('css/help.css')}}"/>
@endpush
@section('content')
    @include('auth.header')
    <div class="help_container fn_clear">
        <div class="main_left">
            @include('layouts.articleTree')
        </div>
        <div class="main_right">
            <h2>{{$page_title or '帮助中心'}}</h2>
            @foreach($result as $v)
                <div class="news_box">
                    <h3>{{str_limit($v->title,20)}}</h3>
                    <p>{!! $v->description !!}</p>
                    <a href="{{route('article.show',['id'=>$v->article_id])}}">查看详情</a>

                </div>
            @endforeach
            {!! $result->links('layouts.page',['show_form'=>1,'inputs'=>$inputs,'action'=>route('article.index'),'show_num'=>2]) !!}
        </div>
    </div>
    @include('auth.footer')
@endsection
