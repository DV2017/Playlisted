<?php
//includes/handlers/ajax/deletePlaylist.php

include("../../config.php");

if(isset($_POST['playlistId'])) {
    //POST function; not GET function; data being sent to db
    //post variables above must match exactly with the variable sent by ajax
    $playlistId = $_POST['playlistId'];

    $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId' ");
    $playlistSongsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId' ");

}
else {
    echo "Playlist id is not passed into deletePlaylist.php.";
}

?>