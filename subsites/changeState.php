<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
		header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");

    if(isset($_POST['data']))
        $id = mysqli_real_escape_string($link, $_POST['data']);
        $stmt = mysqli_prepare($link, "SELECT user_state.name FROM users join user_state on user_state.id_user_state = users.id_state WHERE users.id_user = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $data);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if ($data == 'banned') mysqli_query($link, "update users set id_state = 2 where id_user = '$id'");
        if ($data == 'normal') mysqli_query($link, "update users set id_state = 1 where id_user = '$id'");
        echo $data;
?>