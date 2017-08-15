<div class="top"><span class="title">{{trans('common.user_center')}}</span> <a>>　<span>{{$title1}}</span> </a> <a href="{{$title2}}" class="end">>　<span>{{$title3}}</span></a>
</div>
<div class="main_right1">
    <div class="top_title">
        <h3>{{$title3}}</h3>
        <span class="ico"></span>
        {{$right or ''}}
    </div>
    {{$slot}}
</div>
