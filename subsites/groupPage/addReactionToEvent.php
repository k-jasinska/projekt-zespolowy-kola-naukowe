<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_event = $_POST['id_event'];
    $id_user =$_POST['id_user'];
    $id_reaction_type =$_POST['id_reaction_type'];

    mysqli_query($link, "delete from reactions where id_event='$id_event' and id_user='$id_user';");
    mysqli_query($link, "insert into reactions(id_user,id_reaction_type, id_event) values('$id_user', '$id_reaction_type','$id_event');");

}
else{
    header("Location: index.php");
}
?>  