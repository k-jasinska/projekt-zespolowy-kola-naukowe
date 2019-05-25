<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );

if(!empty($_POST))
{
    $id_member = $_POST['id_member'];
    $q ="SELECT * FROM group_achievements gr where id_group=".$_COOKIE['id_grupy']." and gr.id_group_achievement not in(select id_group_achievements from achievements where id_member=".$id_member.");";
    $res = mysqli_query($link, $q);
    $output = '';
     $output .= '<form role="form" method="post" id="add_userAchievement">';
        while($row = mysqli_fetch_array($res)){
            $output .= '<label><input id="addAc" type="radio" name="userAchievement" data-member="'.$id_member.'" data-value="'.$row["id_group_achievement"].'">'.$row["name"].'</label><br>';
        }

    $output .= '
    <div id="errUA"></div>
    <div class="modal-footer">
            <input type="submit" name="insert" value="Dodaj" class="btn btn-success" />
            <button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
    </div>
    </form>
    ';
    echo $output;
}
else{
    header("Location: index.php");
}
?>  