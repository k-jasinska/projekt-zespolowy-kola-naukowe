<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_post = $_POST['id_post'];
    $id_user =$_POST['id_user'];
    $id_reaction_type =$_POST['id_reaction_type'];

    mysqli_query($link, "delete from reactions where id_post='$id_post' and id_user='$id_user';");
    mysqli_query($link, "insert into reactions(id_user,id_reaction_type, id_post) values('$id_user', '$id_reaction_type','$id_post');");

}
else{
    header("Location: index.php");
}
?>  