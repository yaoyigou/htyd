<div class="main_left fn_clear">
    <div style="background-color: #f2ffd5;">
        <h2><p>{{str_limit($user->user_name,18)}}</p></h2>
        <div class="profile">
            <a href="{{route('user.index')}}"><span class="head_pic"><img
                            src="@if($user->ls_file!=''){{path('upload/user/'.$user->ls_file)}}@else{{path('images/member_20.png')}}@endif"
                            alt="{{$user->user_name}}" title="{{$user->user_name}}"></span></a>
            <div style="line-height:24px;text-align:center;" class="fn_clear">
                <div><span class="name" alt="{{$user->msn}}" title="{{$user->msn}}">{{str_limit($user->msn,18)}}</span>
                </div>
            </div>

        </div>
    </div>
    <div class="list">
        <h3><span class="ico"></span> 交易管理</h3>
        <ul class="list_fist">
            @foreach($user_menu1 as $v)
                <li @if($action==$v->id)class="li_checked"@endif ><a href="{{$v->url}}">{{$v->name}} <span
                                class="right_ico"></span></a></li>
            @endforeach
        </ul>
        <h3><span class="ico2"></span> 我的账户</h3>
        <ul>
            @foreach($user_menu2 as $v)
                <li @if($action==$v->id)class="li_checked"@endif ><a href="{{$v->url}}">{{$v->name}} <span
                                class="right_ico"></span></a></li>
            @endforeach
        </ul>

    </div>
</div>