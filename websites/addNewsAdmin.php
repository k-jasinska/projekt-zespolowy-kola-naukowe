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
	if(isset($_POST['title']) && isset($_POST['text']) && isset($_POST['href'])){
		$title = trim(mysqli_real_escape_string($link, $_POST['title']));
		$text = trim(mysqli_real_escape_string($link, $_POST['text']));
		$href = trim(mysqli_real_escape_string($link, $_POST['href']));
		if(!(strlen($title) <= 100)){
			array_push($errors, "Tytuł ma niedozwoloną długość!");
		}
		if(!(strlen($text) > 0 && strlen($text) <= 2000)){
			array_push($errors, "Treść ma niedozwoloną długość!");
        }
        if(!(strlen($href) <= 1000)){
			array_push($errors, "Link ma niedozwoloną długość!");
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
                $id_user = 1; //change that into function that returns id of logged in user!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				if($stmt = mysqli_prepare($link, "INSERT INTO news(id_user, title, text, href) VALUES(?, ?, ?, ?)")){
                    if(!mysqli_stmt_bind_param($stmt, "isss", $id_user, $title, $text, $href)){
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
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <title>Dodaj aktualność</title>

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
                        <a class="nav-link" style="color: rgb(212, 211, 211);" href="addUsers.php">Dodaj użytkownika</a>
                        <a class="nav-link" style="color: rgb(212, 211, 211);" href="addEventAdmin.php">Dodaj wydażenie</a>
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
		<h1 class="title">Dodaj aktualność:</h1>
        <form id="register-form" method="POST">
          <div class="form-group">
              <label for="title">Tytuł:</label>
              <input id="tilet" type="text" class="form-control" maxlength="100" name="title" required>
          </div>
          <div class = "form-group">
                <label class="form-check-label">Treść:</label>
                <textarea class="form-control" rows = 5 id="text" name="text"></textarea>
          </div>
          <div class="form-group">
              <label for="href">Link:</label>
              <input id="href" type="text" class="form-control" name="href">
          </div>
          <button type="submit" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Dodaj aktualność</button>
        </form>

	</div>


</body>

</html>
