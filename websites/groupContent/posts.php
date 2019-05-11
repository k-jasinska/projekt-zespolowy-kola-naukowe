<?php
 if(isset($_COOKIE['id_grupy'])){
    include('../../subsites/functions.php');
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    if(checkIfLogged()){
        $user_id=getIdOfUser();

        $query5 ="SELECT id_coordinator FROM groups WHERE id_group = '".$_COOKIE["id_grupy"]."';";
        $result5 = mysqli_query($link, $query5);
        $id_coordinator = mysqli_fetch_array($result5);

        $query = "SELECT * FROM posts WHERE id_group = '".$_COOKIE["id_grupy"]."' order by posts.date desc";
        $output ='';
        $result = mysqli_query($link, $query);
        $output .='
        <div class="mt-3 p-3 rounded section_divider">
        <div class="row">
            <h5 class="col-6">Posty</h5>
            <div class="col-6 text-right"><i class="fas fa-plus" name="add" id="add" data-toggle="modal" data-target="#postModal"></i></div>
            </div>
         </div>';
    
        while($row = mysqli_fetch_array($result))
        {
            $query1 = "SELECT nick FROM users WHERE id_user = '".$row["id_user"]."';";
            $result1 = mysqli_query($link, $query1);
            $row1 = mysqli_fetch_array($result1);
    
            $query2 = "SELECT id_reaction_type FROM reactions WHERE id_user = '".$user_id."' and id_post= '".$row["id_post"]."';";
            $result2 = mysqli_query($link, $query2);
            $row2 = mysqli_fetch_array($result2);
                $reaction=$row2["id_reaction_type"];
            $output .= '
            <div class="event mt-3 p-3 article rounded">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h6>'.$row["title"].' </h6>
                </div>
                <div class="col-md-6 text-md-right about-article">';

                if($user_id==$row["id_user"] || $user_id==$id_coordinator["id_coordinator"]){
                    $output .= '<div class="float-md-right float-left mx-1" onClick=deletePost('.$row["id_post"].')><i class="far fa-trash-alt "></i></div>
                    <div class="float-md-right float-left mx-1"><i class="fas fa-pencil-alt"></i></div>';
                }
                
                $output .= '
                    <div class="float-md-right float-left mx-1"><i class="far fa-calendar-alt"></i> ' .$row["date"].'</div>
                    <div class="float-md-right float-left mx-1"><i class="far fa-user"></i> ' .$row1["nick"].'</div>
                    <div class="float-md-none"></div>
                </div>
            </div>
            <div class="content">
                <p>'.$row["text"].'</p>
                </div>
                <div class="reaction text-right"><i class="far fa-thumbs-up '; 
                if($reaction==1){ 
                    $output .=' upClicked';
                } 
                $output .='" onClick=addReactionToPost('.$row['id_post'].','. $user_id.',1)></i> <i class="far fa-thumbs-down '; 
                if($reaction==2){ 
                    $output .=' downClicked';
                } 
                $output .='" onClick=addReactionToPost('.$row['id_post'].','. $user_id.',2)></i>
                </div>
            </div>
            </div>';
        }
    
      echo $output;
    
    }
    else{
        echo "<br>Musisz być zalogowany, aby widzieć posty!";
    }
 }
 else{
     echo "<br>Wybierz koło z listy";
 }
?>