<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
		header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
	mysqli_set_charset($link, "utf8");
	$errors = array();
	$message = NULL;
	if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['pwd']) && isset($_POST['cpwd'])){
		$email = trim(mysqli_real_escape_string($link, $_POST['email']));
		$nick = trim(mysqli_real_escape_string($link, $_POST['nick']));
		$name = trim(mysqli_real_escape_string($link, $_POST['name']));
		$surname = trim(mysqli_real_escape_string($link, $_POST['surname']));
		$pwd = $_POST['pwd'];	
		$cpwd = $_POST['cpwd'];
		if($pwd !== $cpwd){
			array_push($errors, "Wprowadzono różne hasła!");
		}
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 40)){
			array_push($errors, "Błędny format adresu email!");
		}
		if(!(strlen($nick) >= 8 && strlen($nick) <= 40)){
			array_push($errors, "Nick ma niedozwoloną długość!");
		}
		if(!(strlen($name) > 0 && strlen($name) <= 50)){
			array_push($errors, "Imię ma niedozwoloną długość!");
		}
		if(!(strlen($surname) > 0 && strlen($surname) <= 50)){
			array_push($errors, "Nazwisko ma niedozwoloną długość!");
		}
		if(!(strlen($pwd) >= 8 && (strlen($pwd) <= 32))){
			array_push($errors, "Hasło ma niedozwoloną długość!");
		}
		if(!(strlen($nick) >= 8 && strlen($nick) <= 40)){
			array_push($errors, "Nick ma niedozwoloną długość!");
		}
		if(count($errors) == 0){
			try{
				$pwd = password_hash($pwd, PASSWORD_DEFAULT);
				if($pwd === FALSE){
					throw new Exception("Błąd serwera!");
				}
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
				if($stmt = mysqli_prepare($link, "SELECT id_user FROM users WHERE nick LIKE ?")){
					if(!mysqli_stmt_bind_param($stmt, "s", $nick)){
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
				if($stmt = mysqli_prepare($link, "INSERT INTO users(id_state, email, nick, name, surname, id_type, password) VALUES(?, ?, ?, ?, ?, ?, ?)")){
					$state = 2;
					$type = 2;
					if(!mysqli_stmt_bind_param($stmt, "issssis", $state, $email, $nick, $name, $surname, $type, $pwd)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
					$message = "Przejdź do logowania";
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
?>
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
	<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
	<link rel="stylesheet" href="../style/loginPage.css">
	<link rel="stylesheet" href="../style/modal.css">
	<link rel="stylesheet" href="../style/scrollBar.css">
    <title>Rejestracja</title>
    <script type="text/javascript" src="../scripts/RegistrationValidation.js"></script>
</head>
    <div class="register-form">
		<h1 class="title">Zarejestruj się</h1>
		<a href="index.php"><i class="fas fa-home fa-2x lilhomebutton"></i></a>
        <form id="register-form" method="POST">
          <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="email" class="form-control" maxlength="40" name="email" required>
          </div>
		  <div class="form-group">
              <label for="nick">Nick:</label>
              <input id="nick" type="text" class="form-control" minlength="8" maxlength="40" name="nick" required>
          </div>
          <div class="form-group">
              <label for="name">Imię:</label>
              <input type="text" class="form-control" id="name" minlength="1" maxlength="50" name="name" required>
          </div>
          <div class="form-group">
              <label for="surname">Nazwisko:</label>
              <input type="surname" class="form-control" id="surname" minlength="1" maxlength="50" name="surname" required>
          </div>
          <div class="form-group">
              <label for="pwd">Hasło:</label>
              <input type="password" class="form-control" minlength="8" id="pwd" name="pwd" required>
          </div>
          <div class="form-group">
              <label for="cpwd">Potwierdź hasło:</label>
              <input type="password" class="form-control" minlength="8" maxlength="32" id="cpwd" name="cpwd" required>
          </div>
          <button type="submit" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Zarejestruj</button>
        </form>
	</div>
	<?php
		if(count($errors) > 0){
			ob_start();
			?>
				<?php foreach($errors as $error) : ?>
					<div class="error">
						<p><?php echo $error; ?></p>
					</div>
				<?php endforeach ?>
			<?php
			modal('errors', 'Nie udało się utworzyć konta!', ob_get_clean());
		}
	?>
	<?php
		if($message !== NULL){
			ob_start();
			?>
				<div class="message">
					<a href="login.php"><?php echo $message; ?></a>
				</div>
			<?php
			modal('message', 'Utworzono konto!', ob_get_clean());
		}
	?>
<body>
</body>
</html>