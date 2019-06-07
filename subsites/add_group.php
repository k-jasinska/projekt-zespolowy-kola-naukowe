<?php 	
include('../subsites/functions.php');
if(checkIfLogged()){
    header("location: ../websites/index.php");
}

$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
mysqli_set_charset($link, "utf8");

if (isset($_POST['nazwa_kola'])){
    $_POST['nazwa_kola'] = mysqli_real_escape_string($link, $_POST['nazwa_kola']);
    $_POST['opis_kola'] = mysqli_real_escape_string($link, $_POST['opis_kola']);
    $_POST['opiekun_kola'] = mysqli_real_escape_string($link, $_POST['opiekun_kola']);
    $stmt = mysqli_prepare($link, "insert into groups (name, id_coordinator, description) values ('$_POST[nazwa_kola]', '$_POST[opiekun_kola]', '$_POST[opis_kola]')");
    mysqli_stmt_bind_param($stmt, "sis", $_POST['nazwa_kola'], $_POST['opis_kola'], $_POST['opiekun_kola']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
header("location: ../websites/dodaj_kolo.php");
?>