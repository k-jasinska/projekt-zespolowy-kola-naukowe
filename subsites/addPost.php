<?php
session_start();
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    include('functions.php');

if(!empty($_POST))
{
    $title = $_POST['title'];
    $opis_postu =$_POST['opis_postu'];

    if(empty($title) || empty($opis_postu) ) {
        exit("Błąd: Musisz wypełnić wszystkie pola");
    }
    if((strlen($title)<3) || (strlen($title)>100)){
      	exit("Błąd: Tytuł musi mieć 100 znaków");
    }
    if((strlen($opis_postu)<3) || (strlen($opis_postu)>2000)){
		exit("Błąd: Opis musi mieć 2000 znaków");
    }

    $date = date('Y-m-d H:i:s');
    $id_group=$_SESSION['id_grupy'];
    $user_id=getIdOfUser();
    if($user_id){
        mysqli_query($link, "insert into posts(id_user, id_group, title, text, date) values('$user_id', '$id_group', '$title','$opis_postu', '$date');");
    }
    else{
        exit("Błąd: Aby dodać post musisz być zalogowany!");
    }

}
else{
    header("Location: index.php");
}
?>  