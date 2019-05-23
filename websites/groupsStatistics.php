<?php
    include('../subsites/functions.php');
    noCache();
	$logged = checkIfLogged();
    if(!$logged){
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
				</tr>
        	</thead>
        	<tbody>
				<?php
					$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
					if (!mysqli_connect_errno()){
						mysqli_set_charset($link, "utf8");
						$query = 'SELECT g.name, t1.czlonkowie, t2.posty, t3.eventy FROM groups g LEFT JOIN
						(SELECT g.name, count(*) as czlonkowie FROM groups g JOIN member m ON g.id_group = m.id_group GROUP BY g.name) t1 ON g.name = t1.name LEFT JOIN
						(SELECT g.name, count(*) as posty FROM groups g JOIN posts p ON g.id_group = p.id_group GROUP BY g.name) t2 ON t1.name = t2.name LEFT JOIN
						(SELECT g.name, count(*) as eventy FROM groups g JOIN group_events ge ON g.id_group = ge.id_group GROUP BY g.name) t3 ON t2.name = t3.name;';
						$result = mysqli_query($link, $query);
						while($result !== NULL && $result !== FALSE && $row = $row = mysqli_fetch_assoc($result)){
							?>
							<tr>
								<?php
									foreach($row as $key=>$val){
										?>
											<td><?php echo $val === NULL ? 0 : $val; ?></td>
										<?php
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


	<script type="text/javascript" src="../scripts/openWebsite.js"></script>
	<script type="text/javascript" src="../scripts/groupsStatistics.js"></script>	
</body>
</html>