$(function () {

    $(".revise").click(function () {

        var email = $(this).parents("form").find(".email").val();
        var names = $(this).parents("form").find(".names").val();
        var selects2 = $(this).parents("form").find(".select2").val();
        var selects3 = $(this).parents("form").find(".select3").val();
        var selects4 = $(this).parents("form").find(".select4").val();
        var address = $(this).parents("form").find(".address").val();
        var phone = $(this).parents("form").find(".phone").val();
        var msg = "";
        //if (email == "")
        //{
        //    msg += "邮箱不能为空";
        //
        //}
        //else
        //{
        //    if ( !(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test(email)))
        //    {
        //        msg += "电子邮箱格式不正确";
        //    }
        //}
        if (names == "") {
            msg += "姓名不能为空<br/>";

        }
        if (selects2 == 0) {
            msg += "请选择相关的省份<br/>";

        }
        if (selects3 == 0) {
            msg += "请选择相关的市<br/>";

        }
        if (selects4 == 0) {
            msg += "请选择相关的县或区<br/>";

        }
        if (address == "") {
            msg += "请填写详细地址<br/>";

        }
        if (phone == "") {
            msg += "电话号码不能为空<br/>";

        }

        if (msg != "") {
            layer.msg(msg, {icon: 2});
            return false;
        }
        else {
            return true;
        }

    });

    $(".revise_1").click(function () {

        var email = $(this).parents("form").find(".email").val();
        var names = $(this).parents("form").find(".names").val();
        var selects2 = $(this).parents("form").find(".select2").val();
        var selects3 = $(this).parents("form").find(".select3").val();
        var selects4 = $(this).parents("form").find(".select4").val();
        var address = $(this).parents("form").find(".address").val();
        var phone = $(this).parents("form").find(".phone").val();
        var msg = "";
        //if (email == "")
        //{
        //    msg += "邮箱不能为空";
        //
        //}
        //else
        //{
        //    if ( !(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test(email)))
        //    {
        //        msg += "电子邮箱格式不正确";
        //    }
        //}
        if (names == "") {
            msg += "姓名不能为空<br/>";

        }
        if (selects2 == 0) {
            msg += "请选择相关的省份<br/>";

        }
        if (selects3 == 0) {
            msg += "请选择相关的市<br/>";

        }
        if (selects4 == 0) {
            msg += "请选择相关的县或区<br/>";

        }
        if (address == "") {
            msg += "请填写详细地址<br/>";

        }
        if (phone == "") {
            msg += "电话号码不能为空<br/>";

        }

        if (msg != "") {
            layer.msg(msg, {icon: 2});
            return false;
        }
        else {
            return true;
        }

    });
});




