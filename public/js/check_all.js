/**
 * Created by Administrator on 2017-08-07.
 */
function check_all(obj) {
    $('.id_check').prop("checked", obj.prop('checked'));
    $('.check_all').prop("checked", obj.prop('checked'));
}
function is_check(obj, id) {
    var subBox = $("." + obj);
    $("." + id).prop("checked", subBox.length == $("." + obj + ":checked").length ? true : false);
}
function plgm() {
    var ids = '';
    var num = 0;
    $('.id_check:checked').each(function () {
        ids += ',' + $(this).val();
        num++;
    });
    if (num == 0) {
        layer.msg('未选中商品', {icon: 2});
        return false;
    }
    tocart_pl(ids);
}
function plsc(url, msg) {
    var ids = '';
    var num = 0;
    $('.id_check:checked').each(function () {
        ids += ',' + $(this).val();
        num++;
    });
    if (num == 0) {
        layer.msg('未选中商品', {icon: 2});
        return false;
    }
    layer.confirm(msg, function (index) {
        //此处请求后台程序，下方是成功后的前台处理……
        //$('.layui-layer-btn1').click();
        $.ajax({
            url: url,
            type: 'delete',
            data: {ids: ids},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    if (num == $('.id_check').length) {
                        location.reload()
                    }
                    $('.id_check:checked').parents("tr").remove();
                }
                layer.msg(data.msg, {icon: parseInt(data.error) + 1, time: 1000});
            }
        });
    });
}
function delete_cz(obj) {
    var msg = $(obj).attr('title');
    var method = $(obj).attr('method');
    var url = $(obj).attr('url');
    layer.confirm(msg, function (index) {
        //此处请求后台程序，下方是成功后的前台处理……
        //$('.layui-layer-btn1').click();
        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    $(obj).parents("tr").remove();
                }
                layer.msg(data.msg, {icon: parseInt(data.error) + 1, time: 1000});
            }
        });
    });
}
function tocart_pl(ids) {
    $.ajax({
        url: '/cart',
        data: {ids: ids},
        dataType: 'json',
        success: function (data) {
            if (data.error == 0) {
                layer.confirm(data.msg, {
                    btn: ['继续购物', '去结算'], //按钮
                    icon: 1
                }, function (index) {
                    layer.close(index);
                }, function () {
                    location.href = '/cart';
                    return false;
                });
            } else if (data.error == 2) {
                layer.confirm(data.msg, {
                    btn: ['注册', '登录'], //按钮
                    icon: 2
                }, function () {
                    location.href = '/register';
                }, function () {
                    location.href = '/login';
                    return false;
                });
            } else {
                if (data.msg.indexOf('血液制品采购委托书') > 0 || data.msg.indexOf('冷藏药品采购委托书') > 0) {
                    layer.alert(data.msg, {
                        btn: ['下载委托书', '确定'], //按钮
                        icon: 2
                    }, function (index) {
                        location.href = '/uploads/血液制品、冷藏药品采购委托书（二合一）.doc';
                    })
                } else {
                    layer.alert(data.msg, {icon: 2})
                }
            }
        }
    })
}