<div class="title"><img src="{{path('images/help1.png')}}"></div>
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
            @if(count($v->child)>0)
                <div class="subNav @if(isset($cat_id)&&$cat_id==$v->cat_id) currentDd currentDt @endif">{{$v->cat_name}} </div>
                <ul style="display: block" class="navContent">
                    @foreach($v->child as $val)
                        <li><a @if(isset($id)&&$id==$val->cat_id) class="a_checked"
                               @endif href="{{route('article.index',['cat_id'=>$val->cat_id,'type'=>$type])}}"
                               title="{{$val->cat_name}}">{{str_limit($val->cat_name,20)}}</a></li>
                    @endforeach
                </ul>
            @endif
        @endif
    @endforeach
</div>