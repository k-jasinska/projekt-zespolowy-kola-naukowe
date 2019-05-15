<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST['id_member_right']))
{
    $id_member_right = $_POST['id_member_right'];
    mysqli_query($link, "update member_rights set id_right=2 where id_member_right=".$id_member_right.";");
}
else{
    header("Location: index.php");
}
?>  