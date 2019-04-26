<?php
session_start();
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    include('functions.php');

if(!empty($_POST))
{
    $titleAch = $_POST['titleAch'];
    $opis_osiagniecia =$_POST['opis_osiagniecia'];
    $filename=$_FILES['uploadfileA']['name'];
    $filetmpname=$_FILES['uploadfileA']['tmp_name'];
    $filder='imagesuploaded/';

    move_uploaded_file($filetmpname, $folder.$filename);

     if(empty($titleAch) || empty($opis_osiagniecia) ) {
         exit("Błąd: Musisz wypełnić wszystkie pola");
    }
     if((strlen($titleAch)<3) || (strlen($titleAch)>11)){
       	exit("Błąd: Tytuł musi mieć 100 znaków");
    }
    if((strlen($opis_osiagniecia)<3) || (strlen($opis_osiagniecia)>100)){
		exit("Błąd: Opis musi mieć 100 znaków");
    }
    $id_group=$_SESSION['id_grupy'];
    mysqli_query($link, "insert into group_achievements(id_group, name, description, image) values('$id_group', '$titleAch','$opis_osiagniecia', '$filename');");
}
else{
    header("Location: index.php");
}
?>  