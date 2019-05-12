<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_group = $_POST['id_group'];
    $id_user =$_POST['id_user'];

    mysqli_query($link, "insert into member(id_user, id_group) values('".$id_user."', '".$id_group."');");
    $insertID=mysqli_insert_id($link);
    mysqli_query($link, "insert into member_rights(id_member, id_right) values('$insertID', 1);");
}
else{
    header("Location: index.php");
}
?>  