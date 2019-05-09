<?php
if(isset($_POST["id"]))
{
    $link = mysqli_connect("127.0.0.1", "root", "", "pz_projekt");
    mysqli_set_charset ($link , "utf8" );
    $cookie_name = "id_grupy";
    $cookie_value = $_POST['id'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

    $output ='';
  $query = "SELECT * FROM groups WHERE id_group = '".$_POST["id"]."'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  $output .='
    <div class="mt-3 p-3 comment rounded section_divider sectionTitle">
        <h5 class="title">Opis</h5>
    </div>
    <div class="event mt-3 p-3 article rounded">
        <div class="mb-2">
                <h6>'.$row["name"].'</h6>
        </div>
        <div class="content">
            <p>'.$row["description"].'</p>
        </div>
    </div>
    ';
echo $output;
}
else{
    echo "Błąd";
}
?>
