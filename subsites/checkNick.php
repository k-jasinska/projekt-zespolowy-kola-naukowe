<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");
    if(isset($_POST['nick'])){
        $nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
		if($stmt = mysqli_prepare($link, "SELECT id_user FROM users WHERE nick LIKE ?")){
			mysqli_stmt_bind_param($stmt, "s", $nick);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $user);
			if(mysqli_stmt_fetch($stmt)){
				echo('1');
			} else {
				echo('0');
			}
			mysqli_stmt_close($stmt);
		} else {
			echo('1');
		}
    }
?>