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

        $query = "SELECT * FROM users join member on users.id_user=member.id_user join member_rights on member_rights.id_member=member.id_member WHERE member.id_group = '".$_COOKIE["id_grupy"]."' order by member_rights.id_right;";
        $output ='';
        $result = mysqli_query($link, $query);
        $output .='
        <div class="mt-3 p-3 rounded section_divider">
            <h5 class="col-md-12">Członkowie</h5>
         </div>
         <div class="event mt-3 p-3 article rounded">
         
         <table id="table" class="table table-striped table-bordered nowrap" style="width:100%; background-color:white;">
      <thead>
      <tr>
      <th >Imię</th>
      <th >Nazwisko</th>
      <th >E-mail</th>
      <th >Nick</th>';
      if($user_id==$id_coordinator["id_coordinator"]){
        $output .= '
        <th >Osiągnięcia</th>
        <th >Akceptuj/Usuń</th>';
      }
      $output .= '
      </tr>
      </thead>
      <tbody>';
      
      while($row = mysqli_fetch_array($result))
      {
        $output .= '
        <tr><td>'.$row["name"].'</td><td>'.$row["surname"].'</td><td>'.$row["email"].'</td><td>'.$row["nick"].'</td>
        ';
        if($user_id==$id_coordinator["id_coordinator"]){
            if($row["id_right"]==1){
                $output .= '<td></td> <td><i class="fas fa-user-check"  onClick=acceptPerson('.$row["id_member_right"].')></i>  <i class="fas fa-user-times delet" onClick=deletePerson('.$row["id_member"].','.$row["id_member_right"].')></i></td></tr>';
            }
            if($row["id_right"]==2){
                $output .= '<td><input type="button" name="log" id="$row[id_user]" value=" Dodaj " class="btn btn-primary addAchievement"/></td> <td><i class="fas fa-trash-alt delet" onClick=deletePerson('.$row["id_member"].','.$row["id_member_right"].')></i></td></tr>';
            }
        }
      }

      $output .= '
      </tbody>
      </table>';
        $output .= '</div>';
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