function addReactionToPost(id_post, id_user, id_reaction_type) {
    $.ajax({
        url: "../subsites/groupPage/addReactionToPost.php",
        method: "POST",
        data: {
            id_post: id_post,
            id_user: id_user,
            id_reaction_type: id_reaction_type

        },
        success: function () {
            $('#showContent').load('groupContent/posts.php');
        }
    });
}