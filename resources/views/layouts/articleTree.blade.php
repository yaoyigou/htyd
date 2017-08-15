@push('header')
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
@endpush
<div class="title"><img src="@if($type==1) {{path('images/help1.png')}} @else {{path('images/xwzx.png')}} @endif"></div>
<div class="subNavBox">
    @foreach($category as $v)
        @if($type==1)
            @if(count($v->article)>0)
                <div class="subNav @if(isset($cat_id)&&$cat_id==$v->cat_id) currentDd currentDt @endif">{{$v->cat_name}} </div>
                <ul style="display: block" class="navContent">
                    @foreach($v->article as $val)
                        <li><a @if(isset($id)&&$id==$val->cat_id) class="a_checked"
                               @endif href="{{route('article.show',['id'=>$val->article_id,'type'=>$type])}}"
                               title="{{$val->title}}">{{str_limit($val->title,20)}}</a></li>
                    @endforeach
                </ul>
            @endif
        @else
            <a href="{{route('article.index',['type'=>2,'cat_id'=>$v->cat_id])}}">
                <div class="subNav1 @if(isset($cat_id)&&$cat_id==$v->cat_id) subNav @endif">{{$v->cat_name}} </div>
            </a>
        @endif
    @endforeach
</div>