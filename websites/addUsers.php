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
	if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['pwd'])){
		$email = trim(mysqli_real_escape_string($link, $_POST['email']));
		$name = trim(mysqli_real_escape_string($link, $_POST['name']));
		$surname = trim(mysqli_real_escape_string($link, $_POST['surname']));
		$pwd = $_POST['pwd'];		
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 40)){
			array_push($errors, "Błędny format adresu email!");
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
				if($stmt = mysqli_prepare($link, "INSERT INTO users(id_state, email, name, surname, id_type, password) VALUES(?, ?, ?, ?, ?, ?)")){
					$state = 2;
					if ($_POST['type'] == '1') $type = 4;
					if ($_POST['type'] == '2') $type = 3;
					if(!mysqli_stmt_bind_param($stmt, "isssis", $state, $email, $name, $surname, $type, $pwd)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					mysqli_stmt_close($stmt);
					if(!mysqli_commit($link)){
						throw new Exception("Błąd serwera!");
					}
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
	<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <title>Dodaj użytkownika</title>

</head>
<body>

    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administracja</a>
                    <div class="dropdown-menu" style="color: rgb(212, 211, 211); background-color:  rgba(14, 10, 10); font-weight: 400; letter-spacing: 2px; text-decoration: none; font-size: 13px; border-bottom: 1px solid rgb(148, 21, 80);" aria-labelledby="navbarDropdown">
                        <a class="nav-link" style="color: rgb(212, 211, 211);" href="dodaj_kolo.php">Dodaj koło</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link2" href="#">Działalność</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link3" href="#">Spis kół</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link4" href="#">Kontakt</a>
                </li>
                <?php if(!checkIfLogged()) :?>
                    <li class="nav-item">
                        <a class="nav-link" id="link5" href="login.php">Logowanie <i class="fas fa-sign-in-alt"></i></a>
                    </li>
                <?php else :?>
                    <li class="nav-item">
                        <a class="nav-link" id="link5" href="index.php?logout">Wyloguj <i class="fas fa-sign-in-alt"></i></a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <div class="register-form register-form2">
		<h1 class="title">Dodaj użytkownika:</h1>
        <form id="register-form" method="POST">
		  <div class="form-group">
              <label for="type">Typ:</label>
              <select id="type" class="form-control" name="type" required>
				  <option value="1">Opiekun</option>
				  <option value="2">Administrator uczelniany</option>
			  </select>
          </div>
          <div class="form-group">
              <label for="email">Email:</label>
              <input id="email" type="email" class="form-control" maxlength="40" name="email" required>
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
              <input type="password" class="form-control" minlength="8" maxlength="32" id="cpwd" required>
          </div>
          <button type="submit" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Zarejestruj użytkownika</button>
        </form>
	</div>


</body>

</html>
