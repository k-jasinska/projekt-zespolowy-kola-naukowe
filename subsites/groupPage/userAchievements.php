<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_member = $_POST['id_member'];
    $q ="SELECT * FROM group_achievements where id_group=".$_COOKIE["id_grupy"].";";


    $res = mysqli_query($link, $q);
    $output = '';
    while($row = mysqli_fetch_array($res)){
        $output .= '<label><input type="radio" name="userAchievement"> '.$row["name"].'</label><br>';
    }
   

    echo $output;
}
else{
    header("Location: index.php");
}
?>  