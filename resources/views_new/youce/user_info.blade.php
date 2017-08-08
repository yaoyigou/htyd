<div class="fix-title">
    <i class="yyg"></i>我的药易购
    <i class="quxiao" onclick="quxiao()"></i>
</div>
<div class="xinxi">
    <div class="img-box">
        <img src="@if($user->ls_file!=''){{get_img_path('data/feedbackimg/'.$user->ls_file)}}@else{{path('images/member_20.png')}}@endif"/>
    </div>
    <div class="name">
        {{$user->user_name}}
    </div>
    <div class="addr">
        {{$user->msn}}
    </div>
</div>
<ul class="ziliao first-ul">
    <a href="javascript:;">
        <li>
            <p>余额</p>
            <p>{{formated_price($user->user_money)}}</p>
        </li>
    </a>
    <a href="javascript:;">
        <li>
            <p>待付款金额</p>
            <p>{{$wait_amount}}</p>
        </li>
    </a>
    @if($user->UserJnmj)
        <a href="/user/czjl">
            <li>
                <p>充值余额</p>
                <p>{{formated_price($user->UserJnmj->jnmj_amount)}}</p>
            </li>
        </a>
    @endif
</ul>
<ul class="ziliao">
    <a href="/jf/member">
        <li>
            <p>普药积分</p>
            <p>{{$user->pay_points}}</p>
        </li>
    </a>
    <a href="javascript:;">
        <li>
            <p>精品积分</p>
            <p>{{$user->jp_points}}</p>
        </li>
    </a>
    <a href="/user/youhuiq">
        <li>
            <p>优惠劵</p>
            <p>{{$yhq_num or 0}}</p>
        </li>
    </a>
</ul>
<a href="/user/orderList" class="ddgl">
    <i class="icon-ddgl"></i> 订单管理
</a>