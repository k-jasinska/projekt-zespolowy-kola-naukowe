<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST["id_group_achievement"])))
{
    $id_group_achievement = $_POST['id_group_achievement'];
    $result=mysqli_query($link, "select * from group_achievements where id_group_achievement='$id_group_achievement';");
    $row=mysqli_fetch_array($result);
    echo json_encode($row);
}
else{
    header("Location: index.php");
}
?>  