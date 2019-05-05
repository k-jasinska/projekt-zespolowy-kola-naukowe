$(document).ready(function () {
    $('#insert_form').on("submit", function (event) {
        event.preventDefault();
        $.ajax({
            url: "../subsites/groupPage/addPost.php",
            method: "POST",
            data: $('#insert_form').serialize(),
            success: function (data) {
                var cos = data.substring(0, 4);
                if (cos == "Błąd") {
                    $('#err').html(data);
                } else {
                    $('#insert_form')[0].reset();
                    $('#postModal').modal('hide');
                    $('#showContent').load('groupContent/posts.php');
                }
            }
        });
    });
});

$(document).ready(function () {
    $('#insert_ach').on("submit", function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }

        $.ajax({
            url: "../subsites/groupPage/addAchievements.php",
            method: "POST",
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var cos = data.substring(0, 4);
                if (cos == "Błąd") {
                    $('#errA').html(data);
                } else {
                    $('#insert_ach')[0].reset();
                    $('#modalAchievements').modal('hide');
                    $('#showContent').load('groupContent/achievements.php');
                }
            }
        });
    });
});


$(document).ready(function () {
    $('#insert_event').on("submit", function (event) {
        event.preventDefault();
        $.ajax({
            url: "../subsites/groupPage/addEvent.php",
            method: "POST",
            data: $('#insert_event').serialize(),
            success: function (data) {
                var cos = data.substring(0, 4);
                if (cos == "Błąd") {
                    $('#errE').html(data);
                } else {
                    $('#insert_event')[0].reset();
                    $('#modalEvent').modal('hide');
                    $('#showContent').load('groupContent/events.php');
                }
            }
        });
    });
});