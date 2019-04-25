<?php
if(isset($_POST["id_group"]))
{
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

//  $query = "SELECT * FROM groups WHERE id_group = '".$_POST["id_group"]."'";
//  $result = mysqli_query($link, $query);
//  $row = mysqli_fetch_array($result)
 //$output .= '<div>'.$row["description"].' </div>';

    // <div class="bg-dark mt-3 p-3 comment rounded section_divider row sectionTitle">
    //     <h5 class="title col-6">Posty</h5>
    //     <div class="col-6 text-right"><i class="fas fa-plus"></i></div>
    // </div>
    
    // while($row = mysqli_fetch_array($result))
    // {
    // $output .='
    // <div class="event mt-3 p-3 article rounded">
    //     <div class="row mb-2">
    //         <div class="col-md-6">
    //             <h6>'.$row["name"].' </h6>
    //         </div>
    //         <div class="col-md-6 text-md-right about-article">
    //             <div class="float-md-right float-left mx-1"><i class="far fa-trash-alt"></i></div>
    //             <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>
    //             <div class="float-md-right float-left mx-1"><i class="far fa-calendar-alt"></i> date </div>
    //             <div class="float-md-right float-left mx-1"><i class="far fa-user"></i> autor</div>
    //             <div class="float-md-none"></div>
    //         </div>
    //     </div>
    //     <div class="content">
    //         <p>'.$row["description"].'</p>
    //     </div>
    // </div>';
    // }
    echo "dziala";
}
else{
    echo "Błąd";
}
?>
