<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST["id_post"]))
{
    $id_post = $_POST['id_post'];
    $result=mysqli_query($link, "select * from posts where id_post='$id_post';");
    $row=mysqli_fetch_array($result);
    echo json_encode($row);
}
else{
    header("Location: index.php");
}
?>  