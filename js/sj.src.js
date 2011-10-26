(function(){
if ($('#featured')) {
    var w = $('#primary-menu').width();
    $('.slide').width(w);
    $("#carousel").carouFredSel({
        direction   : 'left',
        items       : 1,
        scroll      : {
            items: 1,
            duration: 600,
            easing: "easeInBack",
            pauseOnHover: true
        },
        auto        : true,
        pagination: '#carousel-nav'
    });
    $(window).resize(function(){
        var w = $('#primary-menu').width();
        $('#carousel').width(w);
        $('.slide').width(w);
        $("#carousel").trigger("configuration", ['width', w]);
    });
}
})();

$('#primary-menu > div > ul > li').each(function(){
    if ($('.sub-menu', this).length) {
        $(this).addClass('has_child');
    }
    if ($('.children', this).length) {
        $(this).addClass('has_child');
    }
    $(this).hover(function(){
        $(this).css('z-index', 100);
        $('> ul', this).stop(true, true).slideDown(200);
    }, function(){
        $(this).css('z-index', 1);
        $('> ul', this).stop(true, true).delay(300).slideUp(100);
    });
});

