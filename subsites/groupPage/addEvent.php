<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    include('../functions.php');

if(!empty($_POST))
{
    $titleEvent = $_POST['titleEvent'];
    $opis_wydarzenia =$_POST['opis_wydarzenia'];
    $event_date =$_POST['event_date'];

    if(empty($titleEvent) || empty($opis_wydarzenia) || empty($event_date) ) {
        exit("Błąd: Musisz wypełnić wszystkie pola");
    }
    if((strlen($titleEvent)<3) || (strlen($titleEvent)>100)){
      	exit("Błąd: Tytuł musi mieć 100 znaków");
    }
    if((strlen($opis_wydarzenia)<3) || (strlen($opis_wydarzenia)>2000)){
		exit("Błąd: Opis musi mieć 2000 znaków");
    }

    $date = date('Y-m-d H:i:s');
    $id_group=$_COOKIE['id_grupy'];
    $user_id=getIdOfUser();
    if($user_id){
         mysqli_query($link, "insert into events(id_owner, title, text, date, event_date) values('$user_id', '$titleEvent','$opis_wydarzenia', '$date', '$event_date');");
        $insertID=mysqli_insert_id($link);
        mysqli_query($link, "insert into group_events(id_group, id_event) values('$id_group', '$insertID');");
    }
    else{
        exit("Błąd: Aby dodać post musisz być zalogowany!");
    }
}
else{
    header("Location: index.php");
}
?>  