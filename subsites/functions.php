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
      $session_id = base64_decode(explode(':', $_COOKIE['session'])[1]);
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				return false;
			}
      mysqli_set_charset($link, "utf8");
      $result = mysqli_query($link, "SELECT id_s from sessions where id_session = '$session_id';");
      if($result !== FALSE && $result->num_rows != 0){
        return true;
      } else {
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
?>