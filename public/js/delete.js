function delete_cz(obj, jiedian, fun) {
    var msg = $(obj).attr('title');
    var method = $(obj).attr('method');
    var url = $(obj).attr('url');
    layer.confirm(msg, {icon: 0}, function (index) {
        //此处请求后台程序，下方是成功后的前台处理……
        //$('.layui-layer-btn1').click();
        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    if (typeof(fun) == 'function') {
                        fun();
                    }
                    if ($('.id_check').length == 1) {
                        location.reload()
                    }
                    if (typeof(jiedian) == "undefined") {
                        $(obj).parents("tr").remove();
                    } else {
                        $(obj).parents(jiedian).remove();
                    }
                }
                layer.msg(data.msg, {icon: parseInt(data.error) + 1, time: 1000});
            }
        });
    });
}