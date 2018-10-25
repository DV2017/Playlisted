<?php
//includes/handlers/ajax/createPlaylist.php

include("../../config.php");

if(isset($_POST['name']) && isset($_POST['username'])) {
    //post variables above must match exactly with the variable sent by ajax

    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $posted = mysqli_query($con, "INSERT INTO playlists VALUES(NULL, '$name', '$username', '$date')");
}
else {
    echo "Name or Username parameters not passed into database.";
}

?>