<?php
 if(isset($_COOKIE['id_grupy'])){
    include('../../subsites/functions.php');
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    if(checkIfLogged()){
        $accountType = getUserType();
        $user_id=getIdOfUser();
        $q ="SELECT id_right FROM member_rights join member on member_rights.id_member=member.id_member WHERE member.id_user = '".$user_id."' and member.id_group='".$_COOKIE["id_grupy"]."';";
        $res = mysqli_query($link, $q);
        $id_right = mysqli_fetch_array($res);

        if($id_right['id_right']==2 || $accountType == AccountTypes::AccountTypes["Opiekun"]){
            $query5 ="SELECT id_coordinator FROM groups WHERE id_group = '".$_COOKIE["id_grupy"]."';";
            $result5 = mysqli_query($link, $query5);
            $id_coordinator = mysqli_fetch_array($result5);
    if($accountType == AccountTypes::AccountTypes["Uzytkownik"]){
        $query = "SELECT * FROM group_achievements WHERE id_group = '".$_COOKIE["id_grupy"]."' and id_group_achievement in(select id_group_achievements from achievements join member on(member.id_member=achievements.id_member) where member.id_user = ".$user_id." and member.id_group=".$_COOKIE['id_grupy'].") order by id_group_achievement desc;";
            $output ='';
            $result = mysqli_query($link, $query);
    }
    else{
        $query = "SELECT * FROM group_achievements WHERE id_group = '".$_COOKIE["id_grupy"]."' order by id_group_achievement desc;";
        $result = mysqli_query($link, $query);
    }
            $output ='';
            $output .='
            <div class="mt-3 p-3 rounded section_divider">
            <div class="row">
                <h5 class="col-6">Osiągnięcia</h5>';
                    if($user_id==$id_coordinator["id_coordinator"]){
                        $output .= '<div class="col-6 text-right"><i class="fas fa-plus" data-toggle="modal" data-target="#modalAchievements"></i></div>';
                    }
                    $output .= '</div>
            </div>';
            if(mysqli_num_rows($result)) {
                while($row = mysqli_fetch_array($result))
                {
                    $output .= '
                    <div class="event mt-3 p-3 article rounded">
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <h6>'.$row["name"].'</h6>
                            </div>
                            <div class="col-sm-2 text-sm-right about-article">';
            
                        if($user_id==$id_coordinator["id_coordinator"]){
                            $output .= '<div class="float-md-right float-left mx-1" onClick=deleteAchievement('.$row['id_group_achievement'].',"'. $row['image'].'")><i class="far fa-trash-alt"></i></div>
                            <div class="float-md-right float-left mx-1 editA" id='.$row["id_group_achievement"].'><i class="fas fa-pencil-alt"></i></div>
                            <div class="float-md-none"></div>';
                        }
                        
                        $output .= '
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
            }
            else{
                $output .= '<div style="margin:15px 15px;">Nie posiadasz jeszcze żadnych osiągnięć</div>'; 
            }
            
        echo $output;
        }
        else{
            echo "<br>Musisz poczekać na przyjęcie Cie do koła!";
        }
    }
    else{
        echo "<br>Musisz być zalogowany, aby widzieć osiągnięcia!";
    }
 }
 else{
     echo "<br>Wybierz koło z listy";
 }
?> 
 