<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt") or die(mysqli_connect_error());
    mysqli_set_charset($link, "utf8");
    if(isset($_POST['email'])){
        $email = mysqli_real_escape_string($link, $_POST['email']);
        if(!empty($email)){
            $result = mysqli_query($link, "select id_user from users where email like '$email';");    
            if($result->num_rows == 0){
              echo("0");
            } else {
              echo("1");
            }
        }
    }
?>