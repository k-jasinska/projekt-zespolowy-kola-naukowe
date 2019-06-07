<?php
	function modal($id, $title, $content, $show = true){
	?>
	<div class="modal fade" id="<?php echo $id; ?>" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title"><?php echo $title; ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<?php echo $content; ?>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger pinkbtn" data-dismiss="modal">Zamknij</button>
				</div>
			</div>	
		</div>
	</div>
	<?php if($show): ?>
		<script>
			$("#<?php echo $id; ?>").modal('show');
		</script>
	<?php endif ?>
	<?php
	}

	function checkIfLogged(){
		if(isset($_COOKIE['session'])){      
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "SELECT id_s FROM sessions WHERE id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $session)){
						throw new Exception("Błąd serwera!");
					}
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						return true;
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}		
			}
			catch(Exception $e){
				return false;
			}
		}
    return false;
	}

	function noCache(){
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}

	function keepSession(){
		if(isset($_COOKIE['session'])){
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "UPDATE sessions SET start_date = CURRENT_TIMESTAMP WHERE id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}					
					mysqli_stmt_close($stmt);
				}
				setcookie(
					"session",
					'SESID:'.base64_encode($session_id),
					time() + 1200,
					'/',
					'',
					false,
					true
				);
			}
			catch(Exception $e){
				mysqli_stmt_close($stmt);
			}
		}
	}

	function logout(){
		$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
		if (!mysqli_connect_errno()){
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			if($stmt = mysqli_prepare($link, "DELETE FROM sessions WHERE id_session LIKE ?")){
				if(mysqli_stmt_bind_param($stmt, "s", $session_id)){
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
				}
			}
		}
		setcookie(
			"session",
			'',
			time() - 4200,
			'/',
			'',
			false,
			true
		);
		setcookie("id_grupy",'',time() - 4200,'/');
	}

	function getEmailOfUser(){
		if(isset($_COOKIE['session'])){      
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "SELECT u.email FROM sessions s JOIN users u ON s.id_user = u.id_user WHERE s.id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $email)){
						throw new Exception("Błąd serwera!");
					}
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						return $email;
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}		
			}
			catch(Exception $e){
				return false;
			}
		}
		return false;
	}

	function getIdOfUser(){
		if(isset($_COOKIE['session'])){      
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "SELECT id_user FROM sessions WHERE id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $id)){
						throw new Exception("Błąd serwera!");
					}
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						return $id;
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}		
			}
			catch(Exception $e){
				return false;
			}
		}
		return false;
	}

	//typy uzytkownikow
	abstract class AccountTypes{
		const AccountTypes = array("Admin" => 1, "Uzytkownik" => 2, "Uczelnia" => 3, "Opiekun" => 4, "None" => 5);
	}

	//argumentem jest talbica typów AccountType, funkcja sprawdza czy uzytkownik nalezy
	//do jednego z dozwolonych typow uzytkownikow
	//np. checkIfUserHasAccess(array(AccountTypes::AccountTypes["Uzytkownik"], AccountTypes::AccountTypes["None"]))
	function checkIfUserHasAccess($allowedTypes){
		if(isset($_COOKIE['session'])){      
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "SELECT u.id_type FROM sessions s JOIN users u ON s.id_user = u.id_user WHERE s.id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $id_type)){
						throw new Exception("Błąd serwera!");
					}					
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						foreach($allowedTypes as $type){
							if($type == $id_type){
								return true;
							}
						}
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}		
			}
			catch(Exception $e){
				return false;
			}
		}
		return false;
	}

	function getUserType(){
		if(isset($_COOKIE['session'])){      
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
			mysqli_set_charset($link, "utf8");
			$session_id = mysqli_real_escape_string($link, base64_decode(explode(':', $_COOKIE['session'])[1]));
			$stmt = mysqli_prepare($link, "SELECT u.id_type FROM sessions s JOIN users u ON s.id_user = u.id_user WHERE s.id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "s", $session_id)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_execute($stmt)){
						throw new Exception("Błąd serwera!");
					}
					if(!mysqli_stmt_bind_result($stmt, $id_type)){
						throw new Exception("Błąd serwera!");
					}					
					if(mysqli_stmt_fetch($stmt)){
						mysqli_stmt_close($stmt);
						return $id_type;				
					}
					mysqli_stmt_close($stmt);
				} else {
					throw new Exception("Błąd serwera!");
				}		
			}
			catch(Exception $e){
				return false;
			}
		}
		return false;
	}

	function menu($logged){
		if($logged)
			$accountType = getUserType();
		else
			$accountType = AccountTypes::AccountTypes["None"];
		if($accountType == AccountTypes::AccountTypes["Uzytkownik"]){
			?>
			<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
				<a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> LOGO</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
					aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" id="link2" href="#">Działalność</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link3" href="#">Spis kół</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="groupPage.php">Moje Koła</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="messages.php">Wiadomości</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="userPanel.php">Moje konto</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link4" href="#">Kontakt</a>
						</li>
						<li class="nav-item">
								<a class="nav-link" href="index.php?logout">Wyloguj <i class="fas fa-sign-in-alt"></i></a>
						</li>
					</ul>
				</div>
			</nav>
			<?php
		} else if($accountType == AccountTypes::AccountTypes["Opiekun"]){
			?>
			<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
				<a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> LOGO</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
					aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" id="link2" href="#">Działalność</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link3" href="#">Spis kół</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="groupPage.php">Moje Koła</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="messages.php">Wiadomości</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="userPanel.php">Moje konto</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="myApplications.php">Wnioski</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link4" href="#">Kontakt</a>
						</li>
						<li class="nav-item">
								<a class="nav-link" href="index.php?logout">Wyloguj <i class="fas fa-sign-in-alt"></i></a>
						</li>
					</ul>
				</div>
			</nav>
		<?php
		} else if($accountType == AccountTypes::AccountTypes["Uczelnia"]){
			?>
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
									<a class="nav-link" style="color: rgb(212, 211, 211);" href="addNewsAdmin.php">Dodaj aktualność</a>
									<a class="nav-link" style="color: rgb(212, 211, 211);" href="addEventAdmin.php">Dodaj wydażenie</a>
									<a class="nav-link" style="color: rgb(212, 211, 211);" href="applicationsAdmin.php">Wnioski</a>
									<a class="nav-link" style="color: rgb(212, 211, 211);" href="changeStatusAdmin.php">Zarządzaj użytkownikami</a>
									<a class="nav-link" style="color: rgb(212, 211, 211);" href="groupsStatistics.php">Statystyki</a>
                </div>
            </li>
						<li class="nav-item">
							<a class="nav-link" id="link2" href="#">Działalność</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link3" href="#">Spis kół</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="groupsStatistics.php">Statystyki</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="messages.php">Wiadomości</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="userPanel.php">Moje konto</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link4" href="#">Kontakt</a>
						</li>
						<li class="nav-item">
								<a class="nav-link" href="index.php?logout">Wyloguj <i class="fas fa-sign-in-alt"></i></a>
						</li>
					</ul>
				</div>
			</nav>
		<?php
		} else {
			?>
			<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
				<a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> LOGO</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
					aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
						<ul class="navbar-nav ml-auto">
								<li class="nav-item">
										<a class="nav-link" id="link2" href="#">Działalność</a>
								</li>
								<li class="nav-item">
										<a class="nav-link" id="link3" href="#">Spis kół</a>
								</li>
								<li class="nav-item">
										<a class="nav-link" id="link4" href="#">Kontakt</a>
								</li>
								<li class="nav-item">
										<a class="nav-link" href="login.php">Logowanie <i class="fas fa-sign-in-alt"></i></a>
								</li>
								<li class="nav-item">
										<a class="nav-link" href="register.php">Rejestracja <i class="fas fa-user-plus"></i></a>
								</li>
						</ul>
				</div>
			</nav>
			<?php
		}
	}
?>