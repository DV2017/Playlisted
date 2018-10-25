<?php
//includes/handlers/ajax/addToPlaylist.php

include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    //POST function; not GET function; data being sent to db
    //post variables above must match exactly with the variable sent by ajax
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $orderQuery = mysqli_query($con, "SELECT MAX(playlistOrder) + 1 AS maxOrder FROM playlistSongs WHERE playlistId='$playlistId' ");
    $row = mysqli_fetch_array($orderQuery);
    $order = $row['maxOrder'];
    //check for NULL values in table
    if($order == NULL) {
        $order = 1;
    }
    $query = mysqli_query($con, "INSERT INTO `playlistSongs` (`id`, `songId`, `playlistId`, `playlistOrder`)  VALUES ( NULL, '$songId', '$playlistId', '$order') ");


    
}
else {
    echo "Playlist id is not passed into addToPlaylist.php.";
}

?>