function getClientLocalTime()
{
    var currentTime = new Date()
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()

    return hours + "." + minutes;
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
});