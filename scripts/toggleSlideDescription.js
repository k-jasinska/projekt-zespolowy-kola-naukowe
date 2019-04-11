(function () {
    var groups = document.querySelectorAll(".group-title");

    groups.forEach((group) => {
        group.addEventListener('click', function (e) {
            $(this).toggleClass("group-clicked");
            $(this).next('.group-descr').stop().slideToggle(300);
        });
    });
})();