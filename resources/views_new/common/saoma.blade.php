<div class="pop-wraper" id="win-0710">
    <div class="pop-outer">
        <div class="pop-inner">
            <div class="pop-content">
                <img src="{{$img}}" id="code_img_url">
                <div class="msg_default_box"><i class="icon60_qr pngFix"></i><p>请使用{{$name or '微信'}}扫描<br>二维码以完成支付</p>
                </div>
                <div class="btn btn_cancel"><i class="ico_cancel"></i></div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.btn_cancel').click(function(){
                $('.pop-wraper').remove();
                clearInterval(int);
            })
        })
    </script>
</div>