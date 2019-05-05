<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $event_id = $_POST['id'];
    mysqli_query($link, "delete from group_events where id_event='$event_id' and id_group='".$_COOKIE["id_grupy"]."';");
    mysqli_query($link, "delete from events where id_event='$event_id';");
}
else{
    header("Location: index.php");
}
?>  