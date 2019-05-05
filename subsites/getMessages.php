<?php
	include('../subsites/functions.php');
	noCache();
	$logged = checkIfLogged();
    if($logged){
		if($logged){
			keepSession();
		}
		$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
		if (mysqli_connect_errno()){
			exit();
		}
		mysqli_set_charset($link, "utf8");
		$id = getIdOfUser();
		if($id !== NULL){
			$result = mysqli_query($link, "SELECT u.nick, u.name, u.surname, m.title, m.message, m.date FROM
			users u RIGHT JOIN messages m ON u.id_user = m.id_user_from WHERE m.id_user_to = $id
			ORDER BY m.date");
			$messages = array();
			while($result !== NULL && $result !== FALSE && $row = mysqli_fetch_assoc($result)){
				$data = new stdClass();
				$date = explode("-", $row['date']);
				$day = explode(" ", $date[2])[0];
				$data->table = "<tr><td class='th-1'>$row[nick]</td><td class='th-3'>
				$day.$date[1].$date[0]</td><td class='th-2'>$row[title]</td></tr>";
				foreach($row as $key=>$val)
					$data->data[$key] = $val;
				array_push($messages, $data);
			}
			echo json_encode($messages);
		}
	}
?>