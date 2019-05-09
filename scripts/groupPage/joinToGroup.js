function joinToGroup(id_group, id_user) {
    $.ajax({
        url: "../subsites/groupPage/joinToGroup.php",
        method: "POST",
        data: {
            id_group: id_group,
            id_user: id_user,

        },
        success: function () {
            $('.choose').load('groupContent/buttons.php');
            $('#showContent').load('groupContent/posts.php');
        }
    });
}

$(document).ready(function () {
    $('.eve').click(function () {
        var page = $(this).attr('href');
        $('#showContent').load('groupContent/' + page + '.php');
        return false;
    });
});

// function clickEl() {
//     $('#showContent').load('groupContent/posts.php');
//     // $('#showContent').load('groupContent/' + href + '.php');
//     return false;
// }