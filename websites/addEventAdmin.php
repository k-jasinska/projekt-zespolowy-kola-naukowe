<?php
	include('../subsites/functions.php');
	noCache();
	if(!checkIfLogged()){
		header("location: index.php");
	}
	$access = checkIfUserHasAccess(array("Admin" => 1, "Uczelnia" => 3));
	if(!$access){
        header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");
    $errors = array();
	$message = NULL;
	if(isset($_POST['title']) && isset($_POST['event_desc'])){
		$title = trim(mysqli_real_escape_string($link, $_POST['title']));
		$desc = trim(mysqli_real_escape_string($link, $_POST['event_desc']));
        $date = $_POST['date'];	
		if(!(strlen($title) <= 100)){
			array_push($errors, "Tytuł ma niedozwoloną długość!");
		}
		if(!(strlen($desc) > 0 && strlen($desc) <= 2000)){
			array_push($errors, "Opis ma niedozwoloną długość!");
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
				if($stmt = mysqli_prepare($link, "INSERT INTO events(id_owner, title, text, date, event_date) VALUES(NULL, ?, ?, str_to_date(?, '%d.%m.%Y %H:%i:%s'), str_to_date(?, '%Y-%m-%d'))")){
                    $t = date("m.d.Y H:i:s", time());
                    if(!mysqli_stmt_bind_param($stmt, "ssss", $title, $desc, $t, $date)){
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
	<link rel="stylesheet" href="../style/scrollBar.css">
    <title>Dodaj wydażenie</title>

</head>
<body>

    <!--NAVBAR-->
    <?php
        menu(1);
    ?>

    <div class="register-form register-form2">
		<h1 class="title">Dodaj wydażenie:</h1>
        <form id="register-form" method="POST">
          <div class="form-group">
              <label for="title">Tytuł:</label>
              <input id="tilet" type="text" class="form-control" maxlength="100" name="title" required>
          </div>
          <div class = "form-group">
                <label class="form-check-label">Opis koła</label>
                <textarea class="form-control" rows = 5 id="event_desc" name="event_desc"></textarea>
          </div>
          <div class="form-group">
            <label class="form-check-label">Opis koła</label>
            <input class="form-control" name="date" type="date">
          </div>
          <button type="submit" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Dodaj wydażenie</button>
        </form>

	</div>


</body>

</html>
