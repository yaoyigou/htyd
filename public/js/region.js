//通过省份显示城市的信息
function show_region_list(obj, name) {
    //清空旧的城市信息
    if (name == 'city') {
        obj.nextAll('.district').empty();
        obj.nextAll('.district').append("<option value=''>请选择</option>");
    }
    obj.nextAll('.' + name).empty();
    obj.nextAll('.' + name).append("<option value=''>请选择</option>");
    //获得选中省份的value值
    var pid = obj.val();
    $.ajax({
        url: '/get_region_list',
        type: 'get',
        data: {pid: pid},
        dataType: 'json',
        success: function (data) {
            for (var p in data) {
                console.log(data[p]);
                obj.nextAll('.' + name).append("<option value='" + p + "'>" + data[p] + "</option>");
            }
        },
    });
}