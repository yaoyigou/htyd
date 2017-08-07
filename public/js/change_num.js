/**
 * Created by Administrator on 2017-06-01.
 */
function add_num(id) {
    var gn = parseInt($('#gn_' + id).val());
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseInt($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseInt($('#J_dgoods_num_' + id).val());
    num = num + zbz;
    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8) {//购买数量达到件装量80%
            layer.alert('你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {icon: 0, title: '温馨提示'});
            num = Math.ceil(num / jzl) * jzl;
        }
    }

    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz + zbz;
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num > gn && gn > 0) {
        num = gn;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function reduce_num(id) {
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseInt($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseInt($('#J_dgoods_num_' + id).val());
    num = num - zbz;
    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
            num = num - num % jzl + parseInt(jzl * 0.8);
        }
    }

    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz;
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num < 1) {
        num = zbz;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function changePrice(id) {
    var gn = parseInt($('#gn_' + id).val());
    var yl = parseInt($('#yl_' + id).val());
    var isYl = parseInt($('#isYl_' + id).val());
    var zbz = parseInt($('#zbz_' + id).val());
    var jzl = parseInt($('#jzl_' + id).val());
    var num = parseInt($('#J_dgoods_num_' + id).val());
    if (num < 0) {
        layer.msg('请输入正确的数量', {icon: 2});
        $('#J_dgoods_num_' + id).val(0 - zbz);
        return false;
    }
    if (num == 0) {
        layer.msg('请输入正确的数量', {icon: 2});
        $('#J_dgoods_num_' + id).val(zbz);
        return false;
    }
    if (num % zbz != 0) {//不为中包装整数倍
        num = num - num % zbz + zbz;
    }

    if (jzl) {//件装量存在
        if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
            layer.alert('你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {icon: 0, title: '温馨提示'});
            num = Math.ceil(num / jzl) * jzl;
        }
    }

    if (isYl > 0 && num > isYl && yl > 0) {//商品限购
        num = isYl;
    }

    if (num > gn && gn > 0) {
        num = gn;
    }
    $('#J_dgoods_num_' + id).val(num);
}

function tocart(id) {
    var num = $('#J_dgoods_num_' + id).val();
    $.ajax({
        url: '/cart',
        data: {id: id, num: num},
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
function tocollect(id) {
    $.ajax({
        url: '/collect_goods',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if (data.error == 2) {
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
                layer.alert(data.msg, {icon: data.error + 1, btn: '查看我的收藏'}, function () {
                    location.href = '/collect_goods';
                })
            }
        }
    })
}
function tocart1() {
    layer.confirm('请登录后再操作', {
        btn: ['注册', '登录'], //按钮
        icon: 2
    }, function () {
        location.href = '/register';
    }, function () {
        location.href = '/login';
        return false;
    });
}