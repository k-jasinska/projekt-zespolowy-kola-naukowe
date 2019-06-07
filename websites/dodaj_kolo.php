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
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/loginPage.css">
    <link rel="stylesheet" href="../style/scrollBar.css">
    <title>Dodaj koło</title>
</head>
<body>

    <!--NAVBAR-->
    <?php
        menu(1);
    ?>

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
