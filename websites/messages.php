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
	<link rel="stylesheet" href="../style/messagesPage.css">
	<link rel="stylesheet" href="../style/scrollBar.css">
	<link rel="stylesheet" href="../style/modal.css">
    <title>Koła Naukowe</title>
</head>

<body>

    <!--NAVBAR-->
    <?php
        menu($logged);
	?>
	
	<div class="content">
		<div class="row mx-auto col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="left-part">
					<div class="container mt-3 background msg-menu">
						<ul class="list-group navbar-nav">
							<li class="list-group-item msg-menu-item">
								<a class="nav-link active-msg-menu-item" href="#">Napisz</a>
							</li>
							<li class="list-group-item msg-menu-item">
								<a class="nav-link" href="#">Otrzymane</a>
							</li>
							<li class="list-group-item msg-menu-item">
								<a class="nav-link" href="#">Wysłane</a>
							</li>
						</ul> 
					</div>
					<div class="container mt-3 background search-div">
						<h4 class="text-center">Lista kontaktów</h1>
						<input class="form-control" id="searchInput" type="text" placeholder="Szukaj...">
						<div class="checkbox form-group form-check">
							<label class="form-check-label">
								<input id="check-users" class="form-check-input" type="checkbox" checked> Tylko moje koła
							</label>
						</div>
						<ul class="list-group" id="peopleList">
						</ul> 
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-12">
				<div class="right-part mx-auto">
					<div class="msg-form background">
						<form method="POST" id="msg-form">
						<h2>Utwórz wiadomość</h2>
							<div class="msg-info"></div>
							<div class="form-group">							
								<input type="text" class="form-control form-input" id="nick" placeholder="Nick adresata" required>
							</div>
							<div class="form-group">
								<input type="text" class="form-control form-input" maxlength="100" id="title" placeholder="Temat" required>
							</div>
							<div class="form-group">
								<textarea class="form-control form-input" rows="5" maxlength="2000" id="message" placeholder="Wiadomość..." required></textarea>
							</div>
							<button id="send-msg" type="submit" class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect">Wyślij</button>
							<div id="loader" class="btn btn-danger btn-rounded btn-block z-depth-0 waves-effect" style="display: none">
								<div class="loader mx-auto"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="../scripts/openWebsite.js"></script>
	<script type="text/javascript" src="../scripts/searchList.js"></script>
	<script type="text/javascript" src="../scripts/messagesContent.js"></script>
</body>
</html>