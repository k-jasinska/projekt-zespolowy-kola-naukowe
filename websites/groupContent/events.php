<?php
session_start();
 if(isset($_SESSION['id_grupy'])){
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

     $query = "SELECT * FROM events join group_events on(group_events.id_event=events.id_event) WHERE id_group = '".$_SESSION["id_grupy"]."'";
    $output ='';
    $result = mysqli_query($link, $query);
    $output .='
    <div class="bg-dark mt-3 p-3 rounded section_divider">
    <div class="row">
         <h5 class="col-6">Wydarzenia</h5>
         <div class="col-6 text-right"><i class="fas fa-plus"></i></div>
     </div>
 </div>';

    while($row = mysqli_fetch_array($result))
    {
        $output .= '
        <div class=" event mt-3 p-3 article rounded">
        <div class="row mb-2">
            <div class="col-md-6">
                <h6>'.$row["title"].'</h6>
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
            <p>'.$row["text"].'</p>
        </div>
        <div class="reaction text-right"><i class="far fa-thumbs-up"></i> <i class="far fa-thumbs-down"></i>
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