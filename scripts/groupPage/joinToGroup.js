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