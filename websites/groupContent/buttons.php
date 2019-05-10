<?php
              if(isset($_COOKIE["id_grupy"])){
                include('../../subsites/functions.php');
                $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
                mysqli_set_charset ($link , "utf8" );

                $user_id=getIdOfUser();
                $q=mysqli_query($link, "Select * from member where id_user='".$user_id."' and id_group='".$_COOKIE["id_grupy"]."';");
                $row2 = mysqli_fetch_array($q);
                $reaction=$row2["id_member"];
                if($reaction){
                  echo '
                  <a href="#" onClick=clickEl("posts") class="btn btn-primary eve">Posty</a>
                  <a href="#" onClick=clickEl("events") class="btn btn-primary eve">Wydarzenia</a>
                  <a href="#" onClick=clickEl("achievements") class="btn btn-primary eve">Osiągnięcia</a>
                  <a href="#" onClick=clickEl("members") class="btn btn-primary eve">Członkowie</a>
                  ';
                }
                else{
                  echo '<button onClick=joinToGroup('.$_COOKIE['id_grupy'].','. $user_id.') class="btn btn-primary">Dołącz</button>';
                }
              }
?>