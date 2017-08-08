<div class="title"><img src="{{path('images/help1.png')}}"></div>
<div class="subNavBox">
    @foreach($category as $v)
        @if(count($v->child)>0)
            <div class="subNav @if(isset($cat_id)&&$cat_id==$v->cat_id) currentDd currentDt @endif">{{$v->cat_name}} </div>
            <ul style="display: block" class="navContent">
                @foreach($v->child as $val)
                    <li><a @if(isset($id)&&$id==$val->cat_id) class="a_checked"
                           @endif href="{{route('article.index',['cat_id'=>$val->cat_id])}}"
                           title="{{$val->cat_name}}">{{str_limit($val->cat_name,20)}}</a></li>
                @endforeach
            </ul>
        @endif
    @endforeach
</div>