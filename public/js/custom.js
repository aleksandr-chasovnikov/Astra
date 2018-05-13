;(function ($) {

    // Прижать футер к низу
    if ( document.body.scrollHeight <= window.screen.height) {
        var x = document.getElementsByClassName("footer")[0]
            .setAttribute("class", "navbar-fixed-bottom");
    };

/*=========== Кнопка "ВВЕРХ" ==========================*/
    $('#toTop').fadeOut();
    $(window).scroll(function() {
        // Высота проявления кнопки
        if ($(this).scrollTop() > 200) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });

    $('#toTop').click(function() {
        $('body,html').animate({
            scrollTop: 0
            // Скорость подъема
        }, 1000);
        return false;
    });
/*========== Кнопка "ВВЕРХ" END ==========================*/

    /* ============== SLICK-SLIDER ===============*/
    // $('.slick-slider').slick({
    //     prevArrow: '<button type="button" class="slick-button-left"><i class="fa fa-angle-left fa-3x"><i class="fa fa-angle-left black"></i></button>',
    //     nextArrow: '<button type="button" class="slick-button-right"><i class="fa fa-angle-right fa-3x"><i class="fa fa-angle-right black"></i></button>'
    // });
    //
    // $('.image-sub-slider').click(function () {
    //     var srcCurrent = $(this).attr('src');
    //     $('.slick-slider').find('[' + srcCurrent + ']').closest('slick-slide').addClass('slick-current')
    // });

/* ============ SLICK-SLIDER END =============*/
}) (jQuery);