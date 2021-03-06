<?php
 if(isset($_COOKIE['id_grupy'])){
    include('../../subsites/functions.php');
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    if(checkIfLogged()){
        $accountType = getUserType();
        $user_id=getIdOfUser();
        $q ="SELECT id_right FROM member_rights join member on member_rights.id_member=member.id_member WHERE member.id_user = $user_id and member.id_group=".$_COOKIE['id_grupy'].";";
        $res = mysqli_query($link, $q);
        $id_right = mysqli_fetch_array($res);

        if(($id_right['id_right']==2) || ($accountType == AccountTypes::AccountTypes["Opiekun"])){
            $query5 ="SELECT id_coordinator FROM groups WHERE id_group = '".$_COOKIE["id_grupy"]."';";
            $result5 = mysqli_query($link, $query5);
            $id_coordinator = mysqli_fetch_array($result5);
    
            $query = "SELECT * FROM events join group_events on(group_events.id_event=events.id_event) WHERE id_group = '".$_COOKIE["id_grupy"]."' order by date desc;";
            $output ='';
            $result = mysqli_query($link, $query);
            $output .='
            <div class=" mt-3 p-3 rounded section_divider">
            <div class="row">
                <h5 class="col-6">Wydarzenia</h5>
                <div class="col-6 text-right"><i class="fas fa-plus" data-toggle="modal" data-target="#modalEvent"></i></div>
            </div>
        </div>';
    
        while($row = mysqli_fetch_array($result))
        {
            $query1 = "SELECT nick FROM users WHERE id_user = '".$row["id_owner"]."';";
            $result1 = mysqli_query($link, $query1);
            $row1 = mysqli_fetch_array($result1);
    
            $query2 = "SELECT id_reaction_type FROM reactions WHERE id_user = '".$user_id."' and id_event= '".$row["id_event"]."';";
            $result2 = mysqli_query($link, $query2);
            $row2 = mysqli_fetch_array($result2);
                $reaction=$row2["id_reaction_type"];
            $output .= '
            <div class=" event mt-3 p-3 article rounded">
            <div class="row mb-2">
                <div class="col-md-6">
                    <h6>'.$row["title"].'</h6>
                </div>
                <div class="col-md-6 text-md-right about-article">';
    
                if($user_id==$row["id_owner"] || $user_id==$id_coordinator["id_coordinator"]){
                    $output .= '<div class="float-md-right float-left mx-1" onClick=deleteEvent('.$row["id_event"].')><i class="far fa-trash-alt"></i></div>
                    <div class="float-md-right float-left mx-1 editE" id='.$row["id_event"].'><i class="fas fa-pencil-alt"></i></div>';
                }
                
                $output .= '
                    <div class="float-md-right float-left mx-1"><i class="far fa-calendar-alt"></i>  ' .$row["date"].' </div>
                    <div class="float-md-right float-left mx-1"><i class="far fa-user"></i>  ' .$row1["nick"].'</div>
                    <div class="float-md-none"></div>
                </div>
            </div>
            <div class="content">
                <div>Wydarzenie odbędzie się:<strong> ' .$row["event_date"].' </strong></div>
                <p>'.$row["text"].'</p>
            </div>
            <div class="reaction text-right"><i class="far fa-thumbs-up '; 
            if($reaction==1){ 
                $output .=' upClicked';
            } 
            $output .='" onClick=addReactionToEvent('.$row['id_event'].','. $user_id.',1)></i> <i class="far fa-thumbs-down '; 
            if($reaction==2){ 
                $output .=' downClicked';
            } 
            $output .='" onClick=addReactionToEvent('.$row['id_event'].','. $user_id.',2)></i>
            </div>
        </div> 
          ';
        }
      echo $output;
        }
        else{
            echo "<br>Musisz poczekać na przyjęcie Cie do koła!";
        }
    }
    else{
        echo "<br>Musisz być zalogowany, aby widzieć wydarzenia!";
    }
 }
 else{
     echo "<br>Wybierz koło z listy";
 }
?>