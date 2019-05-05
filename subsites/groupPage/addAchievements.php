<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $titleAch = $_POST['titleAch'];
    $opis_osiagniecia =$_POST['opis_osiagniecia'];

    $name = $_FILES['file']['name'];
    $target_dir = "../../imagesuploaded/";


     if(empty($titleAch) || empty($opis_osiagniecia) ) {
         exit("Błąd: Musisz wypełnić wszystkie pola");
    }
     if((strlen($titleAch)<3) || (strlen($titleAch)>100)){
       	exit("Błąd: Tytuł musi mieć max 30 znaków");
    }
    if((strlen($opis_osiagniecia)<3) || (strlen($opis_osiagniecia)>100)){
		exit("Błąd: Opis musi mieć max 100 znaków");
    }
    $id_group=$_COOKIE['id_grupy'];

    mysqli_query($link, "insert into group_achievements(id_group, name, description, image) values('$id_group', '$titleAch','$opis_osiagniecia', '$name');");
    move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);

}
else{
    header("Location: index.php");
}
?>  