(function () {
    $(document).ready(function () {
        $(".navbar-brand").click(function (e) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $("html").offset().top
            }, 500);
        });
        $("#link2").click(function (e) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $(".dzialalnosc").offset().top - 40
            }, 500);
        });
        $("#link3").click(function (e) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $(".group").offset().top - 40
            }, 500);
        });
        $("#link4").click(function (e) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $(".contactHeader").offset().top - 40
            }, 500);
        });
    });
})();