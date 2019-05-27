$(document).ready(function () {
    $(document).on('click', '.editE', function () {
        var id_event = $(this).attr("id");
        $.ajax({
            url: "../subsites/groupPage/editEvent.php",
            method: "POST",
            data: {
                id_event: id_event
            },
            dataType: "json",
            success: function (data) {
                $('#titleEvent').val(data.title);
                $('#opis_wydarzenia').val(data.text);
                $('#event_date').val(data.date);
                $('#insertEvent').val("Zapisz");
                $('#id_event').val(data.id_event);
                $('#modalEvent').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $(document).on('click', '.editA', function () {
        var id_group_achievement = $(this).attr("id");
        $.ajax({
            url: "../subsites/groupPage/editAchievement.php",
            method: "POST",
            data: {
                id_group_achievement: id_group_achievement
            },
            dataType: "json",
            success: function (data) {
                $('#titleAch').val(data.name);
                $('#opis_osiagniecia').val(data.description);
                $('#file').val(data.image);
                $('#insertAchievement').val("Zapisz");
                $('#id_group_achievement').val(data.id_group_achievement);
                $('#modalAchievements').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $(document).on('click', '.editP', function () {
        var id_post = $(this).attr("id");
        $.ajax({
            url: "../subsites/groupPage/editPost.php",
            method: "POST",
            data: {
                id_post: id_post
            },
            dataType: "json",
            success: function (data) {
                $('#title').val(data.title);
                $('#opis_postu').val(data.text);
                $('#insertPost').val("Zapisz");
                $('#id_post').val(data.id_post);
                $('#postModal').modal('show');
            }
        });
    });
});