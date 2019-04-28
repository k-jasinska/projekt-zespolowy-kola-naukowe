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