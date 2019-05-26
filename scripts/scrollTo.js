(function () {
    $(document).ready(function () {
        
        function getQueryParams(qs) {
            qs = qs.split("+").join(" ");
            var params = {},
                tokens,
                re = /[?&]?([^=]+)=([^&]*)/g;
        
            while (tokens = re.exec(qs)) {
                params[decodeURIComponent(tokens[1])]
                    = decodeURIComponent(tokens[2]);
            }
        
            return params;
        }
        
        var $_GET = getQueryParams(document.location.search);
        if($_GET['focus'] !== undefined)
            setTimeout(sctrollTo($_GET["focus"].replace(/HASH/g, "#"), -40), 200);

        $(".navbar-brand").click(function (e) {
            sctrollTo("html", 0);
        });
        $("#link2").click(function (e) {
            sctrollTo(".dzialalnosc", -40);
        });
        $("#link3").click(function (e) {
            sctrollTo(".group", -40);
        });
        $("#link4").click(function (e) {
            sctrollTo(".contactHeader", -40);
        });

        function sctrollTo(element, offset){
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $(element).offset().top + offset
            }, 500);
        }
    });
})();
