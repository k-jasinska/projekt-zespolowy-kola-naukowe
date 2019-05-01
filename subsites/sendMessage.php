<?php
	include('../subsites/functions.php');
	noCache();
	$logged = checkIfLogged();
    if($logged){
		if($logged){
			keepSession();
		}
		if(isset($_POST["nick"]) && isset($_POST["title"]) && isset($_POST["message"])){
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				echo("1:Błąd serwera!");
				exit();
			}
			$nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
			$title = trim(mysqli_real_escape_string($link, $_POST['title']));
			$message = trim(mysqli_real_escape_string($link, $_POST['message']));
			try{
				$result = mysqli_set_charset($link, "utf8");
				if($result === FALSE){
					throw new Exception("1:Błąd serwera!");
				}
				$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
				if($result === FALSE){
					throw new Exception("1:Błąd serwera!");
				}
				$result = mysqli_autocommit($link, false); 
				if($result === FALSE){
					throw new Exception("1:Błąd serwera!");
				}   
				$result = mysqli_query($link, "BEGIN");
				if($result === FALSE){
					throw new Exception("1:Błąd serwera!");
				}
				if($stmt = mysqli_prepare($link, "SELECT id_user FROM users WHERE nick LIKE ?")){
					if(!mysqli_stmt_bind_param($stmt, "s", $nick)){
						throw new Exception("1:Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("1:Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $user_id_to)){
						throw new Exception("1:Błąd serwera!");
					}
					if(!mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						throw new Exception("2:Błędny nick adresata!");
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("1:Błąd serwera!");
				}
				$user_id_from = getIdOfUser();
				if($user_id_from === FALSE){
					throw new Exception("1:Błąd serwera!");
				}
				if($stmt = mysqli_prepare($link, "INSERT INTO messages(id_user_from, id_user_to, title, message, date) VALUES(?, ?, ?, ?, CURRENT_TIMESTAMP)")){
					if(!mysqli_stmt_bind_param($stmt, "iiss", $user_id_from, $user_id_to, $title, $message)){
						throw new Exception("1:Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("1:Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("1:Błąd serwera!");
					}
				} else {
					throw new Exception("1:Błąd serwera!");
				}
				echo("0:Wiadomość została wysłana!");
			}
			catch(Exception $e){
				mysqli_rollback($link);
				echo($e->getMessage());
			}
		}
	}
?>