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
		$result = mysqli_query($link,"SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ");
		$result = mysqli_autocommit($link, false); 
		$result = mysqli_query($link, "BEGIN");
		mysqli_query($link, "DELETE FROM groups WHERE id_group='$id'");
		if($result !== FALSE && !mysqli_errno($link) && mysqli_affected_rows($link) != 0){
		$query = 
		'SELECT g.name as group_name, g.id_group as group_id, t1.czlonkowie, t2.posty, t3.eventy, u.id_user , concat(u.name, " ", u.surname) as coordinator
		FROM groups g LEFT JOIN users u ON g.id_coordinator = u.id_user LEFT JOIN (SELECT g.name, count(*) as czlonkowie 
		FROM groups g JOIN member m ON g.id_group = m.id_group GROUP BY g.name) t1 ON g.name = t1.name LEFT JOIN 
		(SELECT g.name, count(*) as posty FROM groups g JOIN posts p ON g.id_group = p.id_group GROUP BY g.name) t2 
		ON t1.name = t2.name LEFT JOIN (SELECT g.name, count(*) as eventy FROM groups g JOIN group_events ge ON 
		g.id_group = ge.id_group GROUP BY g.name) t3 ON t2.name = t3.name';
		$result = mysqli_query($link, $query);
		$error = true;
		while($result !== NULL && $result !== FALSE &&  $row = mysqli_fetch_assoc($result)){
			if($error){
			?>
			<table id="stats" class="display nowrap table">
				<thead>
				<tr>
					<th>Koło</th>
					<th>Ilość członków</th>
					<th>Ilość postów</th>
					<th>Ilość wydarzeń</th>
					<th>Kordynator</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
			}
			$error = false;
			?>
			<tr>
			<?php
			$id_user = null;
			foreach($row as $key=>$val){
			if($key === 'coordinator'){
				?>
				<td><span class="coordinator" data-toggle="modal" data-target="#coordinator" data-name="<?php echo $val; ?>" 
				data-id="<?php echo $id_user; ?>" data-group="<?php echo $id_group; ?>" onclick="start_modal(this)">
				<?php echo $val === NULL ? 'BRAK' : $val; ?></span></td>
				<td><span class="remove-group"  data-name="<?php echo $group_name; ?>" data-group="<?php echo $id_group; ?>" 
				onclick="remove_group(this)" data-toggle="modal" data-target="#remove"><i class="far fa-trash-alt"></i></span></td>
				<?php
			} else if($key !== "id_user" && $key !== "group_id") {
				if($key === "group_name"){
				$group_name = $val;
				}
				?>
				<td><?php echo $val === NULL ? 0 : $val; ?></td>
				<?php
			} else if($key === "id_user") {
				$id_user = $val;
			} else if($key === "group_id"){
				$id_group = $val;
			}
			}
			?>
			</tr>
			<?php
		}
		if(!$error){
			?>
				</tbody>
			</table>
			<?php
			mysqli_commit($link);
		} else if (!mysqli_errno($link) && $error){
			?>
			<table id="stats" class="display nowrap table">
				<thead>
					<tr>
						<th>Koło</th>
						<th>Ilość członków</th>
						<th>Ilość postów</th>
						<th>Ilość wydarzeń</th>
						<th>Kordynator</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<?php
			mysqli_commit($link);
			} else {
				echo(1);
			}
		} else {
			echo(0);
		}
	}
?>