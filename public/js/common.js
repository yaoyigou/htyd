$(function () {
    $('.category-list li').hover(function () {
        $(this).addClass('on');
        var index = $(this).index();
        $('.category-list-child li').hide();
        $('.category-list-child li').eq(index).show();
        $('.category-list-child').show();
    }, function () {
        $(this).removeClass('on');
        var index = $(this).index();
        $('.category-list-child').hide();
    });
    $('.category-list-child li').hover(function () {
        $('.category-list-child li').hide();
        $(this).show();
        $('.category-list-child').show();
        var index = $(this).index();
        $('.category-list li').removeClass('on');
        $('.category-list li').eq(index).addClass('on')
    }, function () {
        var index = $(this).index();
        $('.category-list li').removeClass('on');
        $('.category-list-child').hide();
    });
    $(".to_top").click(function () {
        $('body,html').animate({scrollTop: 0}, 400);
        return false;
    });
    $('.hover_fankui').parent().hover(function () {
        $(this).children('.hover_fankui').show();
        $(this).children('.hover_fankui').animate({
            'left': '-80px'
        })
    }, function () {
        $(this).children('.hover_fankui').hide();
        $(this).children('.hover_fankui').animate({
            'left': '-160px'
        })
    });
});
window.onscroll = function () {
    var t = document.documentElement.scrollTop || document.body.scrollTop; //获取滚动距离
    if (t >= 240) {
        $('.fixsearch').fadeIn()
    } else {
        $('.fixsearch').fadeOut()

    }
}