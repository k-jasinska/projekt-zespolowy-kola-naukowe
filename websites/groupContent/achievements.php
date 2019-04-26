<?php
   session_start();
 if(isset($_SESSION['id_grupy'])){

    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

     $query = "SELECT * FROM group_achievements WHERE id_group = '".$_SESSION["id_grupy"]."'";
    $output ='';
    $result = mysqli_query($link, $query);
    $output .='
    <div class="bg-dark mt-3 p-3 rounded section_divider">
    <div class="row">
         <h5 class="col-6">Osiągnięcia</h5>
         <div class="col-6 text-right"><i class="fas fa-plus" style="color:rgb(110, 156, 58); font-size:24px; cursor:pointer;" data-toggle="modal" data-target="#modalAchievements"></i></div>
         </div>
     </div>';

    while($row = mysqli_fetch_array($result))
    {
        $output .= '
        <div class="event mt-3 p-3 article rounded">
        <div class="row mb-2">
            <div class="col-md-6">
                <h6>'.$row["name"].'</h6>
            </div>
            <div class="col-md-6 text-md-right about-article">
                <div class="float-md-right float-left mx-1"><i class="far fa-trash-alt"></i></div>
                <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
                <div class="float-md-none"></div>
            </div>
        </div>
        <div class="content">
            <p>'.$row["description"].'</p>
            <p>image</p>
        </div>
    </div>
      ';
    }
  echo $output;

 }
 else{
     echo "nie działa";
 }
?> 
 