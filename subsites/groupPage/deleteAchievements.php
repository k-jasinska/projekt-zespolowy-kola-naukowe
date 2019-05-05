<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $achievement_id = $_POST['id'];
    $image = $_POST['image'];
    unlink("../../imagesuploaded/".$image);
    mysqli_query($link, "delete from group_achievements where id_group_achievement='$achievement_id';");
}
else{
    header("Location: index.php");
}
?>  