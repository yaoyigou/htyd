$(function () {


    $(".login").click(function () {

        goLogin();

    });


    $(document).keydown(function (e) {

        if (e.keyCode == 13) {

            goLogin()
        }

    });


    $("input[name=user_name]").focus(function () {

        $(this).parent().find(".prompt2").hide();

        $(".codes2").hide();

        $(this).css("color", "#333");

        $(this).parents(".input-box").addClass("border-color-blue");

    });


    $("input[name=password]").focus(function () {

        $(".prompt2").hide();

        $(".codes").hide();

        $(this).css("color", "#333");

        $(this).parents(".input-box").addClass("border-color-blue");

    })

    $("input[name=user_name]").blur(function () {

        if ($(this).val() == "") {

            $(".codes2").show();


        }
        if ($(this).val() != "") {


            $(this).parents(".input-box").removeClass("border-color-red");


        }

        $(this).parents(".input-box").removeClass("border-color-blue");


    });


    $("input[name=password]").blur(function () {


        if ($(this).val() == "") {

            $(".codes").show();


        }

        if ($(this).val() != "") {

            $(this).parents(".input-box").removeClass("border-color-red");

        }

        $(this).parents(".input-box").removeClass("border-color-blue");


    })


});


function goLogin() {

    var username = $(".username").val(),

        password = $(".password").val();

    if (username == "") {


        $(".username").parent().next().show();
        $(".username").parents(".input-box").addClass("border-color-red");


    } else if (password == "") {

        $(".password").parent().next().show();
        $(".password").parents(".input-box").addClass("border-color-red");


    }

    else {

        $(".username").parent().next().hide();
        $(".password").parent().next().hide();

        var act = $(".act").val();

        var back_act = $(".back_act").val();

        var remember = $("#remember").val();

        var url = "/login";

        $.ajax({
            url: url,

            dataType: 'JSON',

            data: {

                act: act,

                user_name: username,

                password: password,

                back_act: back_act,

                remember: remember

            },

            success: function (data) {
                if (data.error == 0) {

                    location.href = '/user';

                }

                if (data.error == 1) {

                    $(".prompt2").eq(1).show().html(data.msg);

                }

            }

        });

    }


    $("input[type=text]").blur();

}