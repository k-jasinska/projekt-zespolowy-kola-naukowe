<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $post_id = $_POST['id'];
    $res=mysqli_query($link, "delete from posts where id_post='$post_id';");
}
else{
    header("Location: index.php");
}
?>  