<?php
 if(isset($_COOKIE['id_grupy'])){
    include('../../subsites/functions.php');
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    if(checkIfLogged()){
        $query = "SELECT * FROM group_achievements WHERE id_group = '".$_COOKIE["id_grupy"]."' order by id_group_achievement desc;";
    $output ='';
    $result = mysqli_query($link, $query);
    $output .='
    <div class="mt-3 p-3 rounded section_divider">
    <div class="row">
         <h5 class="col-6">Osiągnięcia</h5>
         <div class="col-6 text-right"><i class="fas fa-plus" data-toggle="modal" data-target="#modalAchievements"></i></div>
         </div>
     </div>';

    while($row = mysqli_fetch_array($result))
    {
        $output .= '
        <div class="event mt-3 p-3 article rounded">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h6>'.$row["name"].'</h6>
                </div>
                <div class="col-sm-2 text-sm-right about-article">
                    <div class="float-md-right float-left mx-1" onClick=deleteAchievement('.$row['id_group_achievement'].',"'. $row['image'].'")><i class="far fa-trash-alt"></i></div>
                    <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
                    <div class="float-md-none"></div>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-lg-6">
                    <div>'. $row["description"].'</div>
                </div>
                <div class="col-lg-6 text-center">
                <img style="max-width:100%; height:auto;" src="../imagesuploaded/'.$row['image'].'">
                    <div class="float-md-none"></div>
                </div>
            </div>
    </div>
      ';
    }
  echo $output;
    }
    else{
        echo "<br>Musisz być zalogowany, aby widzieć osiągnięcia!";
    }
 }
 else{
     echo "<br>Wybierz koło z listy";
 }
?> 
 