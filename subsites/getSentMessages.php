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
			$result = mysqli_query($link, "SELECT u.nick, u.name, u.surname, m.id_message, m.title, m.message, m.date FROM
			users u RIGHT JOIN messages m ON u.id_user = m.id_user_to WHERE m.id_user_from = $id
			ORDER BY m.date");
			$messages = array();
			while($result !== NULL && $result !== FALSE && $row = mysqli_fetch_assoc($result)){
				$data = new stdClass();
				$date = explode("-", $row['date']);
				$day = explode(" ", $date[2])[0];
				$data->table = "<tr id='msg-$row[id_message]'><td class='td-sender'>$row[nick]</td><td>$day.$date[1].$date[0]
				</td><td data-toggle='tooltip' title='$row[title]'>$row[title]</td><td class='show-col'><i class='fas fa-arrow-circle-right'></i></td></tr>";
				foreach($row as $key=>$val)
					$data->data[$key] = $val;
				array_push($messages, $data);
			}
			echo json_encode($messages);
		}
	}
?>