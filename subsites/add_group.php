<?php 	
include('../subsites/functions.php');
if(checkIfLogged()){
    header("location: ../websites/index.php");
}
//wstawić tu funkcje o typ użytkownika
$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
mysqli_set_charset($link, "utf8");

if (isset($_POST['nazwa_kola'])){
    mysqli_query($link,"insert into groups (name, id_coordinator, description) values ('$_POST[nazwa_kola]', '$_POST[opiekun_kola]', '$_POST[opis_kola]')");
}
header("location: ../websites/dodaj_kolo.php");
?>