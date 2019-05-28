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
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <link rel="stylesheet" href="../style/homePage.css">
    <link rel="stylesheet" href="../style/scrollBar.css">
    <title>Koła Naukowe</title>
</head>

<body>

    <!--NAVBAR-->
    <?php
        menu($logged);
    ?>
    <!-- SLIDER -->
    <div id="slideshow">
        <h2 class="logo">Wspaniali ludzie</h2>
        <h2 class="logo">Nowe możliwości</h2>
        <h2 class="logo">Nie czekaj, dołącz do nas!</h2>
        <slider>
            <slide>
            </slide>
            <slide>
            </slide>
            <slide>
            </slide>
        </slider>
    </div>
    <!-- BODY -->
    <div class="wrapper">
        <section class="description">
            <div>"Powszechnie wiadomo, że w dzisiejszych czasach samo studiowanie nie wystarcza. Trzeba bowiem umieć
                wybić się ponad przeciętność i wyróżnić w tłumie."</div>
        </section>

        <section class="dzialalnosc">
            <?php
                error_reporting(E_ERROR | E_PARSE);
                $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
                if (mysqli_connect_errno()){
                    ?>
                        <div>
                            <h3>Aktualności
                                <span class="underline"></span>
                            </h3>
                            <h3>Przepraszamy nie można było pobrać danych</h3>
                        </div>
                    <?php
                } else {
                    mysqli_set_charset($link, "utf8");
                    $result = mysqli_query($link, "SELECT n.title, n.text, n.href, concat(u.name, ' ', u.surname) as name, 
                    n.id_user FROM news n LEFT JOIN users u ON n.id_user = u.id_user");
                    $empty = true;
                    $create_wrapper = true;
                    ?>
                        <div>
                            <h3>Aktualności
                                <span class="underline"></span>
                            </h3>
                    <?php
                    while($result !== FALSE && $result !== NULL && $row = mysqli_fetch_assoc($result)){
                        $empty = false;
                        if($create_wrapper){
                            $create_wrapper = false;
                            ?>
                            <div class="container-fluid">
                                <div class="row">
                            <?php
                        }
                        ?>
                        <div class="news col">
                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                            <p><?php echo htmlspecialchars($row['text']); ?></p>
                            <?php
                            if($row['id_user'] !== NULL && $row['id_user'] !== ""){
                            ?>
                                <p><?php echo htmlspecialchars($row['name']); ?></p>
                            <?php
                            }
                            ?>
                            <?php
                            if($row['href'] !== NULL && $row['href'] !== ""){
                            ?>
                                <br>
                                <button  onclick="window.location='<?php echo htmlspecialchars($row['href']); ?>'" type="button" class="btn btn-outline-danger pinkbtn">Czytaj więcej...</button>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    if(!$create_wrapper){
                    ?>
                            </div>
                        </div>
                    <?php
                    }
                    if($empty){
                        ?>
                            <h3>Obecnie nie ma żadnych aktualności</h3>
                        </div>
                        <?php
                    } else {
                        ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </section>

        <section>
            <?php
                error_reporting(E_ERROR | E_PARSE);
                $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
                if (mysqli_connect_errno()){
                    ?>
                        <div class="group">
                            <h3>Nasze koła
                                <span class="underline"></span>
                            </h3>
                            <h3>Przepraszamy nie można było pobrać danych</h3>
                        </div>
                    <?php
                } else {
                    mysqli_set_charset($link, "utf8");
                    $result = mysqli_query($link, "SELECT g.name as group_name, g.description, u.name, u.surname FROM 
                    groups g LEFT JOIN users u ON g.id_coordinator = u.id_user");
                    $empty = true;
                    ?>
                        <div class="group">
                            <h3>Nasze koła
                                <span class="underline"></span>
                            </h3>
                    <?php
                    while($result !== FALSE && $result !== NULL && $row = mysqli_fetch_assoc($result)){
                        $empty = false;
                        ?>
                        <div class="container-fluid">
                            <div class="group-title">
                                <h4><?php echo htmlspecialchars($row['group_name']); ?></h4>
                            </div>
                            <div class="group-descr">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <?php echo htmlspecialchars($row['description']); ?>
                                    </div>
                                    <div class="col-sm-4">Opiekun: <?php echo htmlspecialchars($row['name']." ".$row['surname']); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if($empty){
                        ?>
                            <h3>Obecnie nie ma żadnych kół</h3>
                        </div>
                        <?php
                    } else {
                        ?>
                        </div>
                        <?php
                    }
                }
            ?>
        </section>

        <section>
            <h3>Nadal masz wątpliwości?
                <span class="underline"></span>
            </h3>
            <div class="video-responsive"><iframe width="798" height="449"
                    src="https://www.youtube.com/embed/LpVhaUVhMZQ" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </section>

        <h3 class="contactHeader">Skontaktuj sie z nami!
            <span class="underline"></span>
        </h3>
    </div>

    <div class="wrappContact container-fluid">
        <div class="row">
            <form class="col-lg-5 col-md-7 col-sm-12">
                <div class="row">
                    <input type="text" id="defaultContactFormName" class=" mb-4 form-control col-sm-6"
                        placeholder="Imię">
                    <input type="email" id="defaultContactFormEmail" class="form-control mb-4 col-sm-6"
                        placeholder="E-mail">
                </div>
                <input type="text" id="textInput" class="form-control mb-4" placeholder="Tytuł">
                <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3"
                    placeholder="Wiadomość"></textarea>
                <button class="btn btn-danger btn-rounded btn-block z-depth-0 my-4 waves-effect"
                    type="submit">Wyślij</button>
            </form>
            <div class="row col-md-5 col-lg-7">
                <div class="col-sm-6 col-md-12 col-lg-5">
                    <p>Znajdź nas!</p>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-facebook"></i></a>
                </div>
                <div class="col-sm-6 col-md-12 col-lg-7">
                    <p>Kontakt:</p>
                    <div>e-mail: kolanaukowe@gmail.com</div>
                    <div>tel: 123123123</div>
                    <div>www: knLOGO.pl</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        2019 &copy;
    </div>

    <script type="text/javascript" src="../scripts/scrollTo.js"></script>
    <script type="text/javascript" src="../scripts/toggleSlideDescription.js"></script>
</body>

</html>