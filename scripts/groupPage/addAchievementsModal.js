$(document).ready(function () {
    $('#insert_ach').on("submit", function (event) {
        event.preventDefault();
        $.ajax({
            url: "../subsites/addAchievements.php",
            method: "POST",
            data: $('#insert_ach').serialize(),
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