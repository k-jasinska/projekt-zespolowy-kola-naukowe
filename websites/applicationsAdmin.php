<?php
	include('../subsites/functions.php');
	noCache();
	if(!checkIfLogged()){
		header("location: index.php");
    }
    $access = checkIfUserHasAccess(array("Admin" => 1, "Uczelnia" => 3));
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
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
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
    <title>Wnioski</title>
</head>
<body>

    <!--NAVBAR-->
    <?php
        menu(1);
    ?>

    <div class="register-form register-form2">
        <table id="states" class='display nowrap table'>
                    <thead>
                        <tr>
                            <th>Plik</th>
                            <th>E-mail</th>
                            <th>Użytkownik</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
            <tbody id = 'tbody' class="tbody-sent">
            <?php  
                $w = mysqli_query($link, "SELECT applications.id_application, users.name, users.surname, users.email, aplication_state.name as state, applications.file FROM users join applications on applications.id_sender = users.id_user join aplication_state on aplication_state.id_aplication_state = applications.id_state");
                while ($tab2 = mysqli_fetch_assoc($w)){
                    $tab2['name'] = htmlspecialchars($tab2['name']);
                    $tab2['id_application'] = htmlspecialchars($tab2['id_application']);
                    $tab2['email'] = htmlspecialchars($tab2['email']);
                    $tab2['state'] = htmlspecialchars($tab2['state']);
                    $tab2['surname'] = htmlspecialchars($tab2['surname']);
                    $tab2['file'] = htmlspecialchars($tab2['file']);
                    if ($tab2['state'] == 'in progress')
                    echo "<tr id = '$tab2[id_application]'><td><a href='../applicationStorage/$tab2[id_application]$tab2[file]'>$tab2[file]</a></td><td>$tab2[email]</td><td>$tab2[name] $tab2[surname]</td><td id='$tab2[id_application]s'>$tab2[state]</td><td id='$tab2[id_application]b1'><button type='button' class='btn btn-success' style='width:100%' onclick='change_state($tab2[id_application], 1)'>Akceptuj</button></td><td id='$tab2[id_application]b2'><button type='button' class='btn btn-danger' style='width:100%' onclick='change_state($tab2[id_application], 0)'>Odrzuć</button></td></tr>";   
                    else
                    echo "<tr id = '$tab2[id_application]'><td><a href='../applicationStorage/$tab2[id_application]$tab2[file]'>$tab2[file]</a></td><td>$tab2[email]</td><td>$tab2[name] $tab2[surname]</td><td id='$tab2[id_application]s'>$tab2[state]</td><td id='$tab2[id_application]b1'><button type='button' class='btn btn-success' style='width:100%' disabled>Akceptuj</button></td><td id='$tab2[id_application]b2'><button type='button' class='btn btn-danger' style='width:100%' disabled>Odrzuć</button></td></tr>";   
                }
            ?>
        
    </div>
    
    <script>
        function change_state(id, whattodo){
            var data2 = [];
            var q = $.ajax({
                url: '../subsites/changeApplicationState.php',
                type: 'post',
                data: {'data': id, 'do': whattodo}
                })
                .done(function(data){
                    if (data != 0){
                        window.alert('Zmieniono status.');
                        var myNode = document.getElementById(id + 'b1');
                        while (myNode.firstChild){
                            myNode.removeChild(myNode.firstChild);
                        }
                        btn = document.createElement('BUTTON');
                        btn.setAttribute('type', 'button');
                        btn.disabled = true;
                        btn.style.width = '100%';
                        btn.setAttribute('class', 'btn btn-success');
                        tx1 = document.createTextNode('Zaakceptowano');
                        btn.appendChild(tx1);
                        myNode.appendChild(btn);
                        var myNode = document.getElementById(id + 'b2');
                        while (myNode.firstChild){
                            myNode.removeChild(myNode.firstChild);
                        }
                        btn = document.createElement('BUTTON');
                        btn.setAttribute('type', 'button');
                        btn.disabled = true;
                        btn.style.width = '100%';
                        btn.setAttribute('class', 'btn btn-danger');
                        tx1 = document.createTextNode('Odrzucono');
                        btn.appendChild(tx1);
                        myNode.appendChild(btn);

                        var myNode = document.getElementById(id + 's');
                        while (myNode.firstChild){
                            myNode.removeChild(myNode.firstChild);
                        }
                        tx1 = document.createTextNode(data);
                        myNode.appendChild(tx1);
                    }
                    else window.alert('Coś poszło nie tak.');
                });
        }
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
			orderable: false,
			responsivePriority: 0
		 },
		{
			targets: 0,
			responsivePriority: 1
		},
        {
			targets: -2,		
			orderable: false,
			responsivePriority: 0
		 }]		
	});
    </script>
</body>
</html>
