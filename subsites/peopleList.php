<?php
	include('../subsites/functions.php');
	noCache();
	$logged = checkIfLogged();
    if($logged){
		if($logged){
			keepSession();
		}
		if(isset($_GET["all"])){
			$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
			if (mysqli_connect_errno()){
				exit();
			}
			mysqli_set_charset($link, "utf8");
			$id = getIdOfUser();
			$result = NULL;		
			if($_GET["all"] === "false"){
				$result = mysqli_query($link, "SELECT nick FROM users WHERE id_user != $id");
			} else {
				$result = mysqli_query($link, "SELECT u.nick FROM users u JOIN member m ON 
				u.id_user = m.id_user WHERE u.id_user != $id AND 
				(SELECT me.id_group FROM users us JOIN member me ON us.id_user = me.id_user 
				WHERE m.id_group = me.id_group AND us.id_user = $id) IS NOT NULL");
			}
			while($result !== NULL && $result !== "" && $result !== FALSE && $row = mysqli_fetch_assoc($result)){
			?>
				<li class="list-group-item"><?php echo $row["nick"]; ?></li>
			<?php
			}
		}
	}
?>