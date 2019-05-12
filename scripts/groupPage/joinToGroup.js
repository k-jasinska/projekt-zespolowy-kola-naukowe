function acceptPerson(id_member_right) {
    event.preventDefault();
    $.ajax({
        method: "POST",
        url: "../subsites/groupPage/acceptPerson.php",
        data: {
            id_member_right: id_member_right
        },
        success: function () {
            $('#showContent').load('groupContent/members.php');
        },
    });
    return false;
}

function deletePerson(id_member, id_member_right) {
    $.ajax({
        method: "POST",
        url: "../subsites/groupPage/deletePerson.php",
        data: {
            id_member: id_member,
            id_member_right: id_member_right
        },
        success: function () {
            $('#showContent').load('groupContent/members.php');
        },
    });
    return false;
}

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