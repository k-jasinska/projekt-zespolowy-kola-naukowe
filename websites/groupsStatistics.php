<?php
    include('../subsites/functions.php');
    noCache();
	$logged = checkIfLogged();
    if(!$logged){
        header("location: index.php");
	}
	$access = checkIfUserHasAccess(array("Admin" => 1, "Uczelnia" => 3));
	if(!$access){
        header("location: index.php");
	}
	if($logged){
		keepSession();
	}
	$access = checkIfUserHasAccess(array(AccountTypes::AccountTypes["Uczelnia"]));
	if(!$access){
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- TOOLTIP -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C500%2C600%2C700%2C300%2C100%2C800%2C900%7COpen+Sans%3A400%2C300%2C300italic%2C400italic%2C600%2C600italic%2C700%2C700italic&amp;subset=latin%2Clatin-ext&amp;ver=1.3.6"
        type="text/css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<link rel="stylesheet" href="../style/groupsStatistics.css">
	<link rel="stylesheet" href="../style/scrollBar.css">
	<link rel="stylesheet" href="../style/modal.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <title>Koła Naukowe</title>
</head>

<body>

    <!--NAVBAR-->
    <?php
    	menu($logged);
	?>
    <div class="table-container background col-xl-8 col-11 mx-auto">
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
					$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
					if (!mysqli_connect_errno()){
						mysqli_set_charset($link, "utf8");
						$query = 
						'SELECT g.name as group_name, g.id_group as group_id, t1.czlonkowie, t2.posty, t3.eventy, u.id_user , concat(u.name, " ", u.surname) as coordinator
						FROM groups g LEFT JOIN users u ON g.id_coordinator = u.id_user LEFT JOIN (SELECT g.name, count(*) as czlonkowie 
						 FROM groups g JOIN member m ON g.id_group = m.id_group GROUP BY g.name) t1 ON g.name = t1.name LEFT JOIN 
						 (SELECT g.name, count(*) as posty FROM groups g JOIN posts p ON g.id_group = p.id_group GROUP BY g.name) t2 
						 ON t1.name = t2.name LEFT JOIN (SELECT g.name, count(*) as eventy FROM groups g JOIN group_events ge ON 
						 g.id_group = ge.id_group GROUP BY g.name) t3 ON t2.name = t3.name';
						$result = mysqli_query($link, $query);
						while($result !== NULL && $result !== FALSE && $row = $row = mysqli_fetch_assoc($result)){
							?>
							<tr>
								<?php
									$id_user = null;
									$id_group = null;
									$group_name = null;
									foreach($row as $key=>$val){
										$val = htmlspecialchars($val);
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
					}
				?>
        	</tbody>
      	</table>
    </div>

	<div class="modal fade" id="coordinator" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Zmiana kordynatora</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-change">
					<form class="change-coordinator">
						<div class="msg-info"></div>
						<div class="msg-text"></div>
						<br>
						<select id="select_coordinator" class="form-control">
						<select>
						<button id="change-btn" type="submite" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Zmień</button>
					</form>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger pinkbtn" data-dismiss="modal">Zamknij</button>
				</div>
			</div>	
		</div>
	</div>

	<div class="modal fade" id="remove" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Usunięcie koła</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body modal-body-remove">
				<form id="remove-form">
					<div class="msg-info-remove"></div>
					<span id="remove-msg"></span>
					<input type="hidden" id="remove-id">
					<button id="remove-btn" type="submite" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Usuń</button>
				</form>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger pinkbtn" data-dismiss="modal">Zamknij</button>
				</div>
			</div>	
		</div>
	</div>
	<script type="text/javascript" src="../scripts/openWebsite.js"></script>
	<script type="text/javascript" src="../scripts/groupsStatistics.js"></script>	
</body>
</html>