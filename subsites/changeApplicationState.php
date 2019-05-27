<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
		header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root1", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");

    if(isset($_POST['data']) && isset($_POST['do']))
        $id = mysqli_real_escape_string($link, $_POST['data']);
        $do = mysqli_real_escape_string($link, $_POST['do']);
        $stmt = mysqli_prepare($link, "SELECT aplication_state.name FROM aplication_state join applications on aplication_state.id_aplication_state = applications.id_state WHERE applications.id_application = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $data);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($data == 'in progress') {
            if ($do == '1'){
                mysqli_query($link, "update applications set id_state = 2 where id_application = '$id'");
                echo 'accepted';
            }
            if ($do == '0'){
                mysqli_query($link, "update applications set id_state = 1 where id_application = '$id'");
                echo 'denied';
            }
        }
        else echo 0;
?>