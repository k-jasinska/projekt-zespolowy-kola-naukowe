<?php
	include('../subsites/functions.php');
	noCache();
	if(!checkIfLogged()){
		header("location: index.php");
	}
	$access = checkIfUserHasAccess(array("Admin" => 1, "Uzytkownik" => 2, "Uczelnia" => 3, "Opiekun" => 4, "None" => 5));
	if(!$access){
        header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");
	$errors = array();
    $message = NULL;
    if(isset($_POST['email'])){
        $email = trim(mysqli_real_escape_string($link, $_POST['email']));
        if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 40)){
			array_push($errors, "Błędny format adresu email!");
        }
        if(count($errors) == 0){
			try{
				$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				$result = mysqli_autocommit($link, false); 
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}   
				$result = mysqli_query($link, "BEGIN");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				if($stmt = mysqli_prepare($link, "SELECT id_user FROM users WHERE email LIKE ?")){
                    echo $email;
					if(!mysqli_stmt_bind_param($stmt, "s", $email)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $user)){
						throw new Exception("Błąd serwera!");
					}
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						throw new Exception("Email jest już zajęty!");
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
                }
                if($stmt = mysqli_prepare($link, "update users set email = ? where id_user = ?")){
                    $me = getIdOfUser();
					if(!mysqli_stmt_bind_param($stmt, "si", $email, $me)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
					$message = "Zmieniono e-mail";
				} else {
					throw new Exception("Błąd serwera!");
				}
			}
			catch(Exception $e){
				mysqli_rollback($link);
				array_push($errors, $e->getMessage());
			}
        }       
    }
//email end, nick
    if(isset($_POST['nick'])){
        $nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
        if(!(strlen($nick) >= 8 && strlen($nick) <= 40)){
			array_push($errors, "Nick ma niedozwoloną długość!");
		}
        if(count($errors) == 0){
			try{
				$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				$result = mysqli_autocommit($link, false); 
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}   
				$result = mysqli_query($link, "BEGIN");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				if($stmt = mysqli_prepare($link, "SELECT id_user FROM users WHERE nick LIKE ?")){
					if(!mysqli_stmt_bind_param($stmt, "s", $email)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $user)){
						throw new Exception("Błąd serwera!");
					}
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						throw new Exception("Nick jest już zajęty!");
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
                }
                if($stmt = mysqli_prepare($link, "update users set nick = ? where id_user = ?")){
                    $me = getIdOfUser();
					if(!mysqli_stmt_bind_param($stmt, "si", $nick, $me)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
					$message = "Zmieniono nick";
				} else {
					throw new Exception("Błąd serwera!");
				}
			}
			catch(Exception $e){
				mysqli_rollback($link);
				array_push($errors, $e->getMessage());
			}
        }       
    }
    //nick end, n&s

    if(isset($_POST['name']) && isset($_POST['surname'])){
        $name = trim(mysqli_real_escape_string($link, $_POST['name']));
		$surname = trim(mysqli_real_escape_string($link, $_POST['surname']));
        if(!(strlen($name) > 0 && strlen($name) <= 50)){
			array_push($errors, "Imię ma niedozwoloną długość!");
		}
		if(!(strlen($surname) > 0 && strlen($surname) <= 50)){
			array_push($errors, "Nazwisko ma niedozwoloną długość!");
		}
        if(count($errors) == 0){
			try{
				$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				$result = mysqli_autocommit($link, false); 
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}   
				$result = mysqli_query($link, "BEGIN");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
                if($stmt = mysqli_prepare($link, "update users set name = ?, surname = ? where id_user = ?")){
                    $me = getIdOfUser();
					if(!mysqli_stmt_bind_param($stmt, "ssi", $name, $surname,$me)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
					$message = "Zmieniono imię i nazwisko";
				} else {
					throw new Exception("Błąd serwera!");
				}
			}
			catch(Exception $e){
				mysqli_rollback($link);
				array_push($errors, $e->getMessage());
			}
        }       
    }

    //n&s end, pass
    if(isset($_POST['pwd'])){
        $pwd = $_POST['pwd'];
        if(!(strlen($pwd) >= 8 && (strlen($pwd) <= 32))){
			array_push($errors, "Hasło ma niedozwoloną długość!");
        }
        if($pwd != $_POST['cpwd']){
			array_push($errors, "Hasła się nie zgadzają!");
		}
        if(count($errors) == 0){
			try{
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
				$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				$result = mysqli_autocommit($link, false); 
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}   
				$result = mysqli_query($link, "BEGIN");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
                if($stmt = mysqli_prepare($link, "update users set password = ? where id_user = ?")){
                    $me = getIdOfUser();
					if(!mysqli_stmt_bind_param($stmt, "si", $pwd, $me)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
					$message = "Zmieniono hasło";
				} else {
					throw new Exception("Błąd serwera!");
				}
			}
			catch(Exception $e){
				mysqli_rollback($link);
				array_push($errors, $e->getMessage());
			}
        }       
	}
	//pass end
	if(isset($_POST['usun'])){
		if($stmt = mysqli_prepare($link, "delete from users where id_user = ?")){
			$me = getIdOfUser();
			if(!mysqli_stmt_bind_param($stmt, "i", $me)){
				throw new Exception("Błąd serwera!");
			}
			if(!mysqli_stmt_execute($stmt)){
				throw new Exception("Błąd serwera!");
			}
			mysqli_stmt_close($stmt);
			header("location: index.php?logout");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C500%2C600%2C700%2C300%2C100%2C800%2C900%7COpen+Sans%3A400%2C300%2C300italic%2C400italic%2C600%2C600italic%2C700%2C700italic&amp;subset=latin%2Clatin-ext&amp;ver=1.3.6"
        type="text/css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
	<link rel="stylesheet" href="../style/scrollBar.css">
    <title>Moje dane</title>
    <script type="text/javascript" src="../scripts/RegistrationValidation.js"></script>
</head>

<body>

    <!--NAVBAR-->
    <?php menu(1)?>

	<div class="modal fade register-form" id="myModal" role="dialog" style="position: fixed">
		<div class="modal-dialog">
		<div class="modal-content form-control" style='border: 0px'>
			<div class="modal-header">
			<h4 class="modal-title">Czy na pewno chcesz usunąć konto?</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id="register-form" method="POST">
				<div class="modal-body" id = 'modal-body'>
					<button type="submit" name="usun" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Usun konto</button>
				</div>
				<div class="modal-footer">
				</div>
			</form>
		</div>
		
		</div>
	</div>

    <div class="register-form userpanel">
        <form id="register-form1" method="POST">
          <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="email" class="form-control" maxlength="40" name="email" required>
              <button type='submit' class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Zmień</button>
          </div>
        </form>
        <form id="register-form2" method="POST">
		  <div class="form-group">
              <label for="nick">Nick:</label>
              <input id="nick" type="text" class="form-control" minlength="8" maxlength="40" name="nick" required>
              <button type='submit' class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Zmień</button>
          </div>
        </form>
        <form id="register-form3" method="POST">
          <div class="form-group">
              <label for="name">Imię:</label>
              <input type="text" class="form-control" id="name" minlength="1" maxlength="50" name="name" required>
          </div>
          <div class="form-group">
              <label for="surname">Nazwisko:</label>
              <input type="surname" class="form-control" id="surname" minlength="1" maxlength="50" name="surname" required>
          <button type='submit' class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Zmień</button>
          </div>
        </form>
        <form id="register-form4" method="POST">
          <div class="form-group">
              <label for="pwd">Hasło:</label>
              <input type="password" class="form-control" minlength="8" id="pwd" name="pwd" required>
          </div>
          <div class="form-group">
              <label for="cpwd">Potwierdź hasło:</label>
              <input type="password" class="form-control" minlength="8" maxlength="32" id="cpwd" name="cpwd" required>
              <button type='submit' class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Zmień</button>
          </div>
        </form>
		<div class="form-group">
			<button type='button' class='btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect' data-target='#myModal' data-toggle='modal'>Usuń konto</button>
		</div>
	</div>
</body>
</html>