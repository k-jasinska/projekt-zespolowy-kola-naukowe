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
    <link rel="stylesheet" href="../style/modal.css">
    <link rel="stylesheet" href="../style/groupPage.css">
    <title>Koła naukowe</title>
</head>

<body>
	<!-- navbar -->
    <?php
        menu($logged);
	?>
	
    <!-- sidenav -->
    <div class="wrapper1 active show">
        <div class="burger">
            <i class="fas fa-arrow-right visible  active"></i>
            <i class="fas fa-arrow-left visible show active"></i>
        </div>

        <aside class="active show">
            <nav class="menu">
                <h4>Lista kół</h4>
                <input type="text" id="searchInput" class="form-control fas" placeholder="&#xf002"/>
                <ul class="menu__level" id="groupList">
					<?php

						$link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
						mysqli_set_charset ($link , "utf8" );

						$q=mysqli_query($link, "Select * from groups");
						while($tabl=mysqli_fetch_assoc($q)){
						$tabl['id_group']=htmlspecialchars($tabl['id_group']);
						$tabl['name']=htmlspecialchars($tabl['name']);
						$tabl['id_coordinator']=htmlspecialchars($tabl['id_coordinator']);

						 echo"<li><a href='#' onClick='fillDescription(".$tabl['id_group'].")' id='$tabl[id_group]' class='view_data'>$tabl[name]</a></li>";
						}
					?>
                </ul>
            </nav>
        </aside>
    </div>

    <div class="wrapper1 active show">
        <div class="container ">
            <div class="btn-group btn-group-justified choose">
                <a href="posts" class="btn btn-primary">Posty</a>
                <a href="events" class="btn btn-primary">Wydarzenia</a>
                <a href="achievements" class="btn btn-primary">Osiągnięcia</a>
            </div>
        </div> 
		  <div class="container" id="showContent"></div>
	</div>


<!-- modal add post-->
<div class="modal fade" id="postModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Dodaj post</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
        <form role="form" method="post" id="insert_form" >
        <div class="form-group">
                <label for="name">Tytuł:</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Wpisz tytuł" >
                </div>
                <div class="form-group">
                    <label for="surname">Zawartość:</label>
                    <textarea class="form-control" rows = 5 id="opis_postu" name="opis_postu" placeholder="Napisz post"></textarea>
                </div>
                <div id="err"></div>
              <input type="submit" name="insert" value="Dodaj" class="btn btn-success" />
          <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- modal add osiagniecie-->
<div class="modal fade" id="modalAchievements">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Dodaj osiągnięcie</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
        <form role="form" method="post" id="insert_ach" enctype='multipart/form-data'>
        <div class="form-group">
                <label for="titleAch">Tytuł:</label>
                <input type="text" class="form-control" id="titleAch" name="titleAch" placeholder="Wpisz tytuł" >
                </div>
                <div class="form-group">
                    <label for="opis_osiagniecia">Zawartość:</label>
                    <textarea class="form-control" rows = 3 id="opis_osiagniecia" name="opis_osiagniecia" placeholder="Napisz jakie to osiągnięcie"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Dodaj zdjęcie</label>
                    <input type="file" class="form-control-file" name="file" id="file">
                </div>
                <div id="errA"></div>
              <input type="submit" name="insert" value="Dodaj" class="btn btn-success" />
          <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
        </form>
        </div>
      </div>
    </div>
  </div>

    <script src="../scripts/groupPage/deleteElement.js"></script>
    <script src="../scripts/groupPage/addElement.js"></script>
    <script src="../scripts/groupPage/addReaction.js"></script>
	<script src="../scripts/groupPage/fillContent.js"></script>
    <script src="../scripts/groupPage/filterGroups.js"></script>
    <script src="../scripts/hideNavbar.js"></script>

    <link rel="stylesheet" href="../style/endstyle.css">
</body>
</html>