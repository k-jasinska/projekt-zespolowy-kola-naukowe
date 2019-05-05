function deleteAchievement(id, image) {
    $.ajax({
        url: "../subsites/groupPage/deleteAchievements.php",
        method: "POST",
        data: {
            id: id,
            image: image
        },
        success: function () {
            $('#showContent').load('groupContent/achievements.php');
        }
    });
}

function deletePost(id) {
    $.ajax({
        url: "../subsites/groupPage/deletePost.php",
        method: "POST",
        data: {
            id: id
        },
        success: function () {
            $('#showContent').load('groupContent/posts.php');
        }
    });
}

function deleteEvent(id) {
    $.ajax({
        url: "../subsites/groupPage/deleteEvent.php",
        method: "POST",
        data: {
            id: id
        },
        success: function () {
            $('#showContent').load('groupContent/events.php');
        }
    });
}