<?php
	function modal($id, $title, $content){
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
	<script>
		$("#<?php echo $id; ?>").modal('show');
	</script>
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
			$stmt = mysqli_prepare($link, "SELECT id_s from sessions where id_session = ?;");
			try{
				if($stmt){
					if(!mysqli_stmt_bind_param($stmt, "i", $session_id)){
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
				mysqli_stmt_close($stmt);				
				setcookie(
					"session",
					'',
					time() - 4200,
					'/',
					'',
					false,
					true
				);
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
					if(!mysqli_stmt_bind_param($stmt, "i", $session_id)){
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
?>