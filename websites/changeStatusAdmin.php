<?php
	include('../subsites/functions.php');
	noCache();
	if(checkIfLogged()){
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
    <title>Zmień status</title>
</head>
<body>

    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administracja</a>
                    <div class="dropdown-menu" style="color: rgb(212, 211, 211); background-color:  rgba(14, 10, 10); font-weight: 400; letter-spacing: 2px; text-decoration: none; font-size: 13px; border-bottom: 1px solid rgb(148, 21, 80);" aria-labelledby="navbarDropdown">
                        <a class="nav-link" style="color: rgb(212, 211, 211);" href="dodaj_kolo.php">Dodaj koło</a>
                        <a class="nav-link" style="color: rgb(212, 211, 211);" href="addUsers.php">Dodaj użytkownika</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link2" href="#">Działalność</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link3" href="#">Spis kół</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link4" href="#">Kontakt</a>
                </li>
                <?php if(/*!checkIfLogged()*/1) :?>
                    <li class="nav-item">
                        <a class="nav-link" id="link5" href="login.php">Logowanie <i class="fas fa-sign-in-alt"></i></a>
                    </li>
                <?php else :?>
                    <li class="nav-item">
                        <a class="nav-link" id="link5" href="index.php?logout">Wyloguj <i class="fas fa-sign-in-alt"></i></a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <div class="register-form register-form2">
        <table id="states" class='display nowrap table'>
                    <thead>
                        <tr>
                            <th>Użytkownik</th>
                            <th>Status</th>
                        </tr>
                    </thead>
            <tbody id = 'tbody' class="tbody-sent">
            <?php  
                $w = mysqli_query($link, "SELECT users.id_user, users.email, user_state.name FROM users join user_state on user_state.id_user_state = users.id_state");
                while ($tab2 = mysqli_fetch_assoc($w)){
                    $tab2['id_name'] = htmlspecialchars($tab2['name']);
                    $tab2['id_user'] = htmlspecialchars($tab2['id_user']);
                    $tab2['id_email'] = htmlspecialchars($tab2['email']);
                    echo "<tr id = '$tab2[id_user]'><td>$tab2[email]</td><td id='$tab2[id_user]b'><button type='button' class='btn btn-success' style='width:100%' onclick='change_state($tab2[id_user])'>$tab2[name]</button></td></tr>";   
                }
            ?>
        
    </div>
    
    <script>
        function change_state(id){
            var data2 = [];
            var q = $.ajax({
                url: '../subsites/changeState.php',
                type: 'post',
                data: {'data': id}
                })
                .done(function(data){
                    window.alert('Zmieniono status.');
                    var myNode = document.getElementById(id + 'b');
                    while (myNode.firstChild){
                        myNode.removeChild(myNode.firstChild);
                    }
                    btn = document.createElement('BUTTON');
                    btn.setAttribute('type', 'button');
                    btn.style.width = '100%';
                    btn.setAttribute('onclick', "change_state(" + id + ")");
                    if (data == 'normal'){
                        btn.setAttribute('class', 'btn btn-danger');
                        tx1 = document.createTextNode('banned');
                        btn.appendChild(tx1);
                    }
                    if (data == 'banned'){
                        btn.setAttribute('class', 'btn btn-success');
                        tx1 = document.createTextNode('normal');
                        btn.appendChild(tx1);
                    }
                    myNode.appendChild(btn);
                });
        }
        $('#states').DataTable({
		language:{
			"lengthMenu": "_MENU_ na stronę",
			"zeroRecords": "Brak danych",
			"info": "",
			"infoEmpty": "Brak użytkowników",
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
		}]		
	});
    </script>
</body>
</html>
