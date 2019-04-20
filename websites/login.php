<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
		header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
	mysqli_set_charset($link, "utf8");
	delete($link);
	$error = login($link);
	$accounts = read_accounts($link);

	function read_accounts($link){
		$accounts = array();
		foreach($_COOKIE as $key=>$val){
			$name = explode('_', $key);
			if(isset($name[0]) && $name[0] == "remember" && isset($name[1]) && is_numeric($name[1])){
				list($selector, $token) = explode(':', $val);
				$selector = mysqli_real_escape_string($link, $selector);
				try{
					if($stmt = mysqli_prepare($link, "SELECT email FROM authorization_tokens a JOIN users u ON a.id_user = u.id_user WHERE selector like ?")){
						if(!mysqli_stmt_bind_param($stmt, "s", $selector)){
							throw new Exception("Błąd serwera!");
						}
						if(!mysqli_stmt_execute($stmt)){
							throw new Exception("Błąd serwera!");
						}
						if(!mysqli_stmt_bind_result($stmt, $email)){
							throw new Exception("Błąd serwera!");
						}
						if(mysqli_stmt_fetch($stmt)){
							$account['email'] = $email;
							$account['selector'] = $selector;
							array_push($accounts, $account);
						}
						mysqli_stmt_close($stmt);
						return $accounts;
					} else {
						throw new Exception("Błąd serwera!");
					}
				}
				catch(Exception $e){
					$accounts = NULL;
				}
			}
		}
	}

	function remember($link, $id_user){
		if(isset($_POST['remember']) && $_POST['remember'] == "on"){
			$result = mysqli_autocommit($link, true); 
			$counter = 0;
			foreach($_COOKIE as $key=>$val){
				$name = explode('_', $key);
				if(isset($name[0]) && $name[0] == "remember" && isset($name[1]) && is_numeric($name[1])){
					list($selector, $token) = explode(':', $val);
					$selector = mysqli_real_escape_string($link, $selector);
					try{
						if($stmt = mysqli_prepare($link, "SELECT id_token FROM authorization_tokens WHERE id_user=? AND selector like ?")){
							if(!mysqli_stmt_bind_param($stmt, "is", $id_user, $selector)){
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
								throw new Exception("Błąd serwera!");
							}
							mysqli_stmt_close($stmt);
						} else {
							throw new Exception("Błąd serwera!");
						}
						$counter++;
					}
					catch(Exception $e){							
						return 0;
					}
				}
			}
			$result = FALSE;
			do{
				$selector = base64_encode(random_bytes(9));
				$result = mysqli_query($link, "SELECT id_token FROM authorization_tokens WHERE selector LIKE '$selector'");
			}while($result !== FALSE && $result->num_rows > 0);
			if($result !== FALSE){
				$token = random_bytes(33);
				$hash = hash('sha256', $token);
				$date = date('Y-m-d H:i:s', time() + 86400 * 30);					
				if(mysqli_query($link, "INSERT INTO authorization_tokens(id_user, selector, token, expires) VALUES('$id_user', '$selector', '$hash', '$date')")){
					setcookie(
						"remember_$counter",
						$selector.':'.base64_encode($token),
						time() + 86400 * 30,
						'/',
						'',
						false,
						true
					);
				}
			}
		}
	}

	function login($link){
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
				$delete = false;
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
						$delete = true;
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}
				if($delete){
					$result = mysqli_query($link, "DELETE FROM sessions WHERE id_s = $session");
					if($result === FALSE || mysqli_errno($link)){
						throw new Exception("Błąd serwera!");
					}
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
				$result = mysqli_query($link, "INSERT INTO sessions(id_session, id_user, start_date) VALUES('$new_session', $id_user, CURRENT_TIMESTAMP)");
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				$result = setcookie(
					"session",
					'SESID:'.base64_encode($new_session),
					time() + 1200,
					'/',
					'',
					false,
					true
				);
				if($result === FALSE){
					throw new Exception("Błąd serwera!");
				}
				if(!mysqli_commit($link)){
					throw new Exception("Błąd serwera!");
				}
				remember($link, $id_user);
				header("location: index.php");
			}
			catch(Exception $e){
				mysqli_rollback($link);
				$error = $e->getMessage();
				return $error;
			}
		} else if(isset($_POST["selector"])){
			foreach($_COOKIE as $key=>$val){
				$name = explode('_', $key);
				if(isset($name[0]) && $name[0] == "remember" && isset($name[1]) && is_numeric($name[1])){
					list($selector, $token) = explode(':', $val);
					$selector = mysqli_real_escape_string($link, $selector);
					if($_POST["selector"] == $selector){
						try{
							if($stmt = mysqli_prepare($link, "SELECT token FROM authorization_tokens WHERE selector like ?")){
								if(!mysqli_stmt_bind_param($stmt, "s", $selector)){
									throw new Exception("Błąd serwera!");
								}
								if(!mysqli_stmt_execute($stmt)){
									throw new Exception("Błąd serwera!");
								}
								if(!mysqli_stmt_bind_result($stmt, $tokenHash)){
									throw new Exception("Błąd serwera!");
								}
								if(!mysqli_stmt_fetch($stmt)){
									throw new Exception("Błąd serwera!"); 
								} else {
									if(!hash_equals($tokenHash, hash('sha256', base64_decode($token)))){
										throw new Exception("Niepowodzenie autoryzacji!");
									}
								}
								mysqli_stmt_close($stmt);
							} else {
								throw new Exception("Błąd serwera!");
							}
						}
						catch(Exception $e){							
							$error = $e->getMessage();
							return $error;
						}
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
							$result = mysqli_query($link, "DELETE FROM sessions WHERE id_user = $id_user");
							if($result === FALSE || mysqli_errno($link)){
								throw new Exception("Błąd serwera!");
							}
							$new_session = md5(rand(-10000,10000) . microtime()) . md5(crc32(microtime()) . $_SERVER['REMOTE_ADDR']);			
							$result = mysqli_query($link, "INSERT INTO sessions(id_session, id_user, start_date) VALUES('$new_session', $id_user, CURRENT_TIMESTAMP)");
							if($result === FALSE){
								throw new Exception("Błąd serwera!");
							}
							if(!mysqli_commit($link)){
								throw new Exception("Błąd serwera!");
							}
							mysqli_autocommit($link, true); 
							$result = setcookie(
								"session",
								'SESID:'.base64_encode($new_session),
								time() + 1200,
								'/',
								'',
								false,
								true
							);
							header("location: index.php");
						}
						catch(Exception $e){
							mysqli_rollback($link);
							$error = $e->getMessage();
							return $error;
						}
					}
				}
			}
		}
		return NULL;
	}

	function delete($link){
		if(isset($_POST['delete'])){
			$selector = mysqli_real_escape_string($link, $_POST['delete']);
			try{
				$removed = FALSE;
				foreach($_COOKIE as $key=>$val){
					$name = explode('_', $key);
					if(isset($name[0]) && $name[0] == "remember" && isset($name[1]) && is_numeric($name[1])){
						list($cookieSelector, $token) = explode(':', $val);
						$cookieSelector = mysqli_real_escape_string($link, $cookieSelector);
						if($cookieSelector == $selector){
							$removed = setcookie(
								$key,
								"",
								time() - 4200,
								'/',
								'',
								false,
								true
							);
						}
					}
				}
				if(!$removed){
					throw new Exception("Błąd serwera!");
				}
				if($stmt = mysqli_prepare($link, "DELETE FROM authorization_tokens WHERE selector like ?")){
					if(!mysqli_stmt_bind_param($stmt, "s", $selector)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
				} else {
					throw new Exception("Błąd serwera!");
				}
			}
			catch(Exception $e){
				echo("0");
				exit();
			}
			echo("1");
			exit();
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
	<link rel="stylesheet" href="../style/modal.css">
	<script type="text/javascript" src="../scripts/accountsList.js"></script>
    <title>Logowanie</title>
</head>
    <div class="form-login">
        <h1 class="title">Zaloguj się</h1>
        <form method="POST">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" name="email">
			</div>
			<div class="form-group">
				<label for="pwd">Hasło:</label>
				<input type="password" class="form-control" id="pwd" name="pwd">
			</div>
			<div class="form-group form-check">
				<label class="form-check-label">
				<input class="form-check-input" type="checkbox" name="remember"> Zapamiętaj mnie
				</label>
			</div>
			<button  type="submite" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Zaloguj</button>
			<?php if($accounts !== NULL && count($accounts) > 0) :?>
				<button id="btn-remember" type="button" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect" data-toggle="modal" data-target="#accounts">Konta</button>
			<?php endif ?>
        </form>
	</div>
	<?php
		if($accounts !== NULL){
			ob_start();
			?>
				<?php foreach($accounts as $account) : ?>
					<div class="account">
						<span>
							<p>
								<?php echo $account['email']; ?>
							</p>
							<form method="POST" style="display: none;">
								<input type="hidden" value="<?php echo $account['selector']; ?>" name="selector">
							</form>
							<button type="button" class="close delete-account" data-selector="<?php echo $account['selector']; ?>">&times;</button>
						</span>
					</div>
				<?php endforeach ?>
			<?php
			modal('accounts', 'Zapamiętane konta', ob_get_clean(), false);
		}
	?>
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