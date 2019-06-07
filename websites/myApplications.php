<?php
	include('../subsites/functions.php');
	noCache();
	if(!checkIfLogged()){
		header("location: index.php");
    }
    $access = checkIfUserHasAccess(array("Admin" => 1, "Opiekun" => 4));
	if(!$access){
        header("location: index.php");
	}
	$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C500%2C600%2C700%2C300%2C100%2C800%2C900%7COpen+Sans%3A400%2C300%2C300italic%2C400italic%2C600%2C600italic%2C700%2C700italic&amp;subset=latin%2Clatin-ext&amp;ver=1.3.6"
        type="text/css" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <link rel="stylesheet" href="../style/scrollBar.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="../style/messagesPage.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <title>Wnioski</title>
</head>
<body>

    <!--NAVBAR-->
    <?php
        menu(1);
    ?>

<?php
    if (isset($_POST['submit']))
        if($_FILES["ufile"]["type"] == 'application/pdf'){
            $me = getIdOfUser();
            $stmt = mysqli_prepare($link, "insert into applications (id_sender, id_reciever, id_state, file) values ($me, 1, 3, ?)");
            $_FILES['ufile']['name'] = mysqli_real_escape_string($link, $_FILES['ufile']['name']);
            mysqli_stmt_bind_param($stmt, "s", $_FILES['ufile']['name']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $last_id = mysqli_insert_id($link);
            $target_dir = "../applicationStorage/";
            $target_file = $target_dir . $last_id . basename($_FILES["ufile"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            move_uploaded_file($_FILES['ufile']['tmp_name'], $target_file);
            echo '<script>window.alert("Wniosek został wysłany.");</script>';
        }
        else echo '<script>window.alert("Zły format pliku! Wybierz pdf.");</script>';
?>

    <div class="modal fade register-form" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content form-control" style='border: 0px'>
        <div class="modal-header">
          <h4 class="modal-title">Wniosek</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="myApplications.php" id="register-form" method="POST" enctype="multipart/form-data">
            <div class="modal-body" id = 'modal-body'>
                <div class="form-group">
                    <input id='ufile' type="file" class="inputfile" style='border: 0px' name="ufile" required>
                    <label for="ufile"><span></span><strong>Załącz plik pdf</strong></label>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Wyślij</button>
            </div>
        </form>
      </div>
      
    </div>
    </div>

    
    <div class="register-form register-form2">
        <button type='button' style='width:100%;' class='btn btn-success' data-target='#myModal' data-toggle='modal'>Nowy wniosek</button>
        <hr>
        <table id="states" class='display nowrap table'>
                    <thead>
                        <tr>
                            <th>Plik</th>
                            <th>Status</th>
                        </tr>
                    </thead>
            <tbody id = 'tbody' class="tbody-sent">
            <?php  
                $me = getIdOfUser();
                $w = mysqli_query($link, "SELECT applications.id_application, aplication_state.name as state, applications.file FROM applications join aplication_state on aplication_state.id_aplication_state = applications.id_state where applications.id_sender = $me");
                while ($tab2 = mysqli_fetch_assoc($w)){
                    $tab2['id_application'] = htmlspecialchars($tab2['id_application']);
                    $tab2['state'] = htmlspecialchars($tab2['state']);
                    $tab2['file'] = htmlspecialchars($tab2['file']);
                    echo "<tr id = '$tab2[id_application]'><td><a href='../applicationStorage/$tab2[id_application]$tab2[file]'>$tab2[file]</a></td><td id='$tab2[id_application]s'>$tab2[state]</td></tr>";   
                }
            ?>


    </div>
    
    <script>
        
        $('#states').DataTable({
		language:{
			"lengthMenu": "_MENU_ na stronę",
			"zeroRecords": "Brak danych",
			"info": "",
			"infoEmpty": "Brak wniosków",
			"infoFiltered": "(odfiltrowano z _MAX_ wszystkich rekordów)",
			"search": "",
			"searchPlaceholder": "Szukaj",
			"paginate": {
				"previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>",
				"next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>"
			}
		},
		responsive: true,
		columnDefs: [ {
			targets: -1,
			responsivePriority: 0
		 },
		{
			targets: 0,
			responsivePriority: 1
		}]		
	});

    /*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

'use strict';

;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));
    </script>
</body>
</html>
