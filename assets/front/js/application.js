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
    $('.date-inpt').datepicker();
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
});