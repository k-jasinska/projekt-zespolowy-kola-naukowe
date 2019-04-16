<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
		header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
	mysqli_set_charset($link, "utf8");
	$error = NULL;
	if(isset($_POST['email']) && isset($_POST['pwd'])){
		$email = trim(mysqli_real_escape_string($link, $_POST['email']));
		$pwd = $_POST['pwd'];
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
			if($stmt = mysqli_prepare($link, "SELECT id_s FROM sessions JOIN users ON sessions.id_user = users.id_user WHERE users.email LIKE ?")){
				if(!mysqli_stmt_bind_param($stmt, "s", $email)){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_stmt_execute($stmt)){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_stmt_bind_result($stmt, $session)){
					throw new Exception("Błąd serwera!");
				}
				if(mysqli_stmt_fetch($stmt)){
					$result = mysqli_query($link, "DELETE FROM sessions WHERE id_s = $session LIMIT 1");
					if($result === FALSE || mysqli_errno($link) || mysqli_affected_rows($link) == 0){
						throw new Exception("Błąd serwera!");
					}
				}
				mysqli_stmt_close($stmt);
			} else {
				throw new Exception("Błąd serwera!");
			}
			if($stmt = mysqli_prepare($link, "SELECT id_user, password FROM users WHERE email LIKE ?")){
				if(!mysqli_stmt_bind_param($stmt, "s", $email)){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_stmt_execute($stmt)){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_stmt_bind_result($stmt, $id_user, $password_hash)){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_stmt_fetch($stmt)){
					throw new Exception("Błędny email!");
				}
				mysqli_stmt_close($stmt);
			} else {
				throw new Exception("Błąd serwera!");
			}
			if(!password_verify($pwd, $password_hash)){
				throw new Exception("Błędne hasło!");
			}
			$new_session = md5(rand(-10000,10000) . microtime()) . md5(crc32(microtime()) . $_SERVER['REMOTE_ADDR']);
			$result = mysqli_query($link, "INSERT INTO sessions(id_session, id_user, start_date) VALUES($new_session, $id_user, CURRENT_TIMESTAMP)");
			if($result === FALSE){
				throw new Exception("Błędne hasło!");
			}
			$result = setcookie(
				"session",
				'SESID:'.base64_encode($new_session),
				time() + 1200,
				'/~kjanus/',
				'torus.uck.pk.edu.pl',
				false,
				true
			);
			if($result === FALSE){
				throw new Exception("Błędne hasło!");
			}
			header("location: index.php");
		}
		catch(Exception $e){
			mysqli_rollback($link);
			$error = $e->getMessage();
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
    <link rel="stylesheet" href="../style/loginPage.css">
    <title>Logowanie</title>
</head>
    <div class="form-login">
        <h1 class="title">Zaloguj się</h1>
        <form action="/action_page.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email">
        </div>
        <div class="form-group">
            <label for="pwd">Hasło:</label>
            <input type="password" class="form-control" id="pwd">
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
            <input class="form-check-input" type="checkbox"> Zapamiętaj mnie
            </label>
        </div>
        <button  type="button" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Zaloguj</button>
        </form>
	</div>
	<?php
		if($error !== NULL){
			ob_start();
			?>
				<div class="error">
					<p><?php echo $error; ?></p>
				</div>
			<?php
			modal('errors', 'Nie udało się zalogować!', ob_get_clean());
		}
	?>
<body>
</body>
</html>