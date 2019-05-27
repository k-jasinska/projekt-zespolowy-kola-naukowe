<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST["id_event"]))
{
    $id_event = $_POST['id_event'];
    $result=mysqli_query($link, "select * from events where id_event='$id_event';");
    $row=mysqli_fetch_array($result);
    echo json_encode($row);
}
else{
    header("Location: index.php");
}
?>  