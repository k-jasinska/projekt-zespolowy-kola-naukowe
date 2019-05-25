<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_group_ach = $_POST['id_group_ach'];
    $id_member = $_POST['id_member'];
    mysqli_query($link, "insert into achievements(id_group_achievements, id_member) values(".$id_group_ach.",".$id_member.");");
    echo $_COOKIE['id_member'];
}
else{
    header("Location: index.php");
}
?>  