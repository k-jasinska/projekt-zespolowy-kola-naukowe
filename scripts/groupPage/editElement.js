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