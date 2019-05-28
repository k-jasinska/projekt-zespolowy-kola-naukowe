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
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <title>Dodaj koło</title>
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
                <li class="nav-item">
                    <a class="nav-link" id="link2" href="#">Działalność</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link3" href="#">Spis kół</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link4" href="#">Kontakt</a>
                </li>
                <?php if(!checkIfLogged()) :?>
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

    <div class="form-login">
        <h2>Dodaj koło</h2>
        <form method="POST" action = "../subsites/add_group.php">
            <div class = "form-group">
                <label class="form-check-label">Nazwa koła</label>
                <input type = "text" class="form-control" id="nazwa_kola" name="nazwa_kola">
            </div>
            <div class = "form-group">
                <label class="form-check-label">Opiekun koła</label>
                <select class="form-control" id="opiekun_kola" name="opiekun_kola">
                    <?php
                        $w = mysqli_query($link,"select id_user, name, surname from users where id_type = (select id_type from account_types where type = 'opiekun koła')");
                        while($q = mysqli_fetch_assoc($w)){
                        echo "<option style = 'background-color: rgb(37, 37, 37);' value = $q[id_user]>$q[name] $q[surname]</option>";
                        }
                    ?>
                </select>
            </div>
            <div class = "form-group">
                <label class="form-check-label">Opis koła</label>
                <textarea class="form-control" rows = 5 id="opis_kola" name="opis_kola"></textarea>
            </div>
            <div class = "form-group">
                <button type = "submit" class="btn btn-success btn-rounded btn-block z-depth-0 my-4 waves-effect">Utwórz koło</button>
            </div>
        </form>
    </div>


</body>

</html>
