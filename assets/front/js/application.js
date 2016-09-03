function scroll_to_bottom(wrapper)
{
    $(wrapper).scrollTop($(wrapper)[0].scrollHeight);
}

function getClientLocalTime()
{
    var currentTime = new Date()
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()

    return hours + "." + minutes;
}

function fb_share_dialog(url)
{
    FB.ui({
        method: 'share',
        href: url,
    }, function (response) {
    });
}

$(document).ready(function () {
//    $('.date-inpt').datepicker();
    var datepicker_dateformat="dd-M-yy";
    $("#dt1").datepicker({
        dateFormat: datepicker_dateformat,
        minDate: 0,
        onSelect: function (date) {
            var date2 = $('#dt1').datepicker('getDate');
            date2.setDate(date2.getDate() + 1);
            $('#dt2').datepicker('setDate', date2);
            //sets minDate to dt1 date + 1
            $('#dt2').datepicker('option', 'minDate', date2);
        }
    });
    $('#dt2').datepicker({
        dateFormat: datepicker_dateformat,
        onClose: function () {
            var dt1 = $('#dt1').datepicker('getDate');
            console.log(dt1);
            var dt2 = $('#dt2').datepicker('getDate');
            if (dt2 <= dt1) {
                var minDate = $('#dt2').datepicker('option', 'minDate');
                $('#dt2').datepicker('setDate', minDate);
            }
        }
    });
    $('.custom-select').customSelect();
    $(function () {
        $(document.body).on('appear', '.fly-in', function (e, $affected) {
            $(this).addClass("appeared");
        });
        $('.fly-in').appear({force_process: true});
    });

    $(".owl-slider").owlCarousel({
        loop: true,
        margin: 28,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            620: {
                items: 2,
                nav: true
            },
            900: {
                items: 3,
                nav: false
            },
            1120: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    });
    $slideHover();

    var e = parseFloat(getClientLocalTime());
    if ((e >= 0 && e <= 4.3) || (e >= 5 && e <= 7.3)) {
        $(".header-phone").removeClass("hide")
    }

    $('.add-region-click').click(function (e) {
        e.preventDefault();
        var new_div = $('.region-info').html();
        $('.new-region-div-here').append(new_div);
    });

    $(document).on('change', '.post-media-type', function () {
        var media_type = $(this).val();
        if (media_type == 'image')
        {
            $(this).parent().parent().parent().parent().find('.post-image').removeClass('hidden');
            $(this).parent().parent().parent().parent().find('.post-video').addClass('hidden');
        }
        else if (media_type == 'video')
        {
            $(this).parent().parent().parent().parent().find('.post-image').addClass('hidden');
            $(this).parent().parent().parent().parent().find('.post-video').removeClass('hidden');
        }
    });

    var num_of_inputs = jQuery(".gMapLocation-cities").length;
    var i;
    var loop = num_of_inputs - 1;
    for (i = "0"; i <= loop; i++) {
        var options = {types: ["(cities)"]};
        var input = jQuery(".gMapLocation-cities")[i];
        var autocomplete = new google.maps.places.Autocomplete(input, options)
    }

    setTimeout(function () {
        $('.notification-area').slideUp('slow');
    }, 2500);

    $('.track-external-redirect').click(function (e) {
        e.preventDefault();
        var next_url = $(this).attr('href');
        if (next_url != '#' && next_url != '')
        {
            next_url = js_base_url + 'r?url=' + next_url;
            if ($(this).attr('target') == '_blank')
            {
                window.open(next_url);
            }
            else
            {
                window.location.href = next_url;
            }
        }
    });

    $(document.body).on('appear', '.fly-in', function (e, $affected) {
        $(this).addClass("appeared");
        $('.about-percent-a').each(function () {
            var $value = $(this).attr('data-percentage');
            if ($(this).is(':in-viewport')) {
                $(this).find('span').animate({
                    width: $value + '%'
                }, 1400);
            }
        });
    });
    $('.fly-in').appear({force_process: true});
});