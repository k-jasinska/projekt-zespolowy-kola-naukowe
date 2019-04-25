<?php
    include('../subsites/functions.php');
    noCache();
    $logged = checkIfLogged();
    if(isset($_GET['logout']) && $logged){
        logout();
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
    <link rel="stylesheet" href="../style/groupPage.css">
    <title>Koła naukowe</title>
</head>

<body>
	<!-- navbar -->
    <?php
        menu($logged);
	?>
	
    <!-- sidenav -->
    <div class="wrapper1 active">
        <div class="burger">
            <i class="fas fa-arrow-right visible show active"></i>
            <i class="fas fa-arrow-left visible active"></i>
        </div>

        <aside class="active">
            <nav class="menu">
                <h4>Lista kół</h4>
                <input type=" text" class="form-control fas" placeholder="&#xf002"/>
                <ul class="menu__level">
					<?php
						$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
						mysqli_set_charset ($link , "utf8" );

						$q=mysqli_query($link, "Select * from groups");
						while($tabl=mysqli_fetch_assoc($q)){
						$tabl['id_group']=htmlspecialchars($tabl['id_group']);
						$tabl['name']=htmlspecialchars($tabl['name']);
						$tabl['id_coordinator']=htmlspecialchars($tabl['id_coordinator']);
						$tabl['description']=htmlspecialchars($tabl['description']);

						echo"<li><a href=''>$tabl[name]</a></li>";
						}
					?>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="wrapper1 active">
        <div class="container ">
            <div class="btn-group btn-group-justified choose">
                <a href="#" class="btn btn-primary">Opis</a>    
                <a href="#" class="btn btn-primary">Posty</a>
                <a href="#" class="btn btn-primary">Wydarzenia</a>
                <a href="#" class="btn btn-primary">Osiągnięcia</a>
            </div>
        </div>

        <div class="container">
            <div class="bg-dark mt-3 p-3 comment rounded section_divider row sectionTitle">
                <h5 class="title col-6">Posty</h5>
                <div class="col-6 text-right"><i class="fas fa-plus"></i></div>
            </div>

            <div class="event mt-3 p-3 article rounded">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h5>title </h5>
                    </div>
                    <div class="col-md-6 text-md-right about-article">
                        <div class="float-md-right float-left mx-1"><i class="far fa-trash-alt"></i></div>
                        <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
                        <div class="float-md-right float-left mx-1"><i class="far fa-calendar-alt"></i> date </div>
                        <div class="float-md-right float-left mx-1"><i class="far fa-user"></i> autor</div>
                        <div class="float-md-none"></div>
                    </div>
                </div>
                <div class="content">
                    <p>text</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="bg-dark mt-3 p-3 comment rounded section_divider row">
                <h5 class="title col-6">Wydarzenia</h5>
                <div class="col-6 text-right"><i class="fas fa-plus"></i></div>
            </div>

            <div class=" event mt-3 p-3 article rounded">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h5>title </h5>
                    </div>
                    <div class="col-md-6 text-md-right about-article">
                        <div class="float-md-right float-left mx-1"><i class="far fa-trash-alt"></i></div>
                        <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
                        <div class="float-md-right float-left mx-1"><i class="far fa-calendar-alt"></i> date </div>
                        <div class="float-md-right float-left mx-1"><i class="far fa-user"></i> autor</div>
                        <div class="float-md-none"></div>
                    </div>
                </div>
                <div class="content">
                    <p>text</p>
                </div>
                <div class="reaction text-right"><i class="far fa-thumbs-up"></i> <i class="far fa-thumbs-down"></i>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="bg-dark mt-3 p-3 comment rounded section_divider row">
                <h5 class="title col-6">Osiągnięcia</h5>
                <div class="col-6 text-right"><i class="fas fa-plus"></i></div>
            </div>

            <div class="event mt-3 p-3 article rounded">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h5>name</h5>
                    </div>
                    <div class="col-md-6 text-md-right about-article">
                        <div class="float-md-right float-left mx-1"><i class="far fa-trash-alt"></i></div>
                        <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
                        <div class="float-md-none"></div>
                    </div>
                </div>
                <div class="content">
					<p>desctiptions</p>
					<p>image</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../scripts/filterGroups.js"></script>
    <script src="../scripts/hideNavbar.js"></script>
</body>
</html>