<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_member = $_POST['id_member'];
    $id_member_right = $_POST['id_member_right'];
    $query=mysqli_query($link, "delete from member_rights where id_member_right='.$id_member_right.';");
    $query=mysqli_query($link, "delete from member where id_member='.$id_member.';");
}
else{
    header("Location: index.php");
}
?>  