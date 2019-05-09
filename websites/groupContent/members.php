<?php
 if(isset($_COOKIE['id_grupy'])){
    include('../../subsites/functions.php');
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    if(checkIfLogged()){
        $user_id=getIdOfUser();
        $query = "SELECT * FROM users join member on users.id_user=member.id_user WHERE member.id_group = '".$_COOKIE["id_grupy"]."';";
        $output ='';
        $result = mysqli_query($link, $query);
        $output .='
        <div class="mt-3 p-3 rounded section_divider">
            <h5 class="col-md-12">Członkowie</h5>
         </div>';
    
        while($row = mysqli_fetch_array($result))
        {
            $output .= '
            <div class="event mt-3 p-3 article rounded">
                <div>
                    <h6>'.$row["name"].' '.$row["surname"].'</h6>
                </div>
            </div>';
        }
      echo $output;
    
    }
    else{
        echo "<br>Musisz być zalogowany, aby widzieć członków grupy!";
    }
 }
 else{
     echo "<br>Wybierz koło z listy";
 }
?>