<?php
	include('../subsites/functions.php');
	noCache();
	$logged = checkIfLogged();
	if($logged){
		keepSession();
	} else {
		exit();
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
	if (mysqli_connect_errno()){
		exit();
	}
	mysqli_set_charset($link, "utf8");
	if(isset($_POST['id'])){
		$id = mysqli_real_escape_string($link, $_POST['id']);
		$result = mysqli_query($link, "SELECT id_user, name, surname FROM users 
		WHERE id_type = 4 AND id_user != '$id'");
		while($result !== NULL && $result !== FALSE && $row = $row = mysqli_fetch_assoc($result)){
			?>
				<option value="<?php echo $row['id_user']; ?>"><?php 
				echo $row['name']." ".$row['surname']; ?></option>
			<?php
		}
	}
?>