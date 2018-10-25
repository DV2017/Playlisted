<?
//includes/handlers/ajax/removeFromPlaylist.php

include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    //POST function; not GET function; data being sent to db
    //post variables above must match exactly with the variable sent by ajax
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];

    $query = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId' AND songId='$songId' ");
    
}
else {
    echo "Playlist id or songId is not passed into removeFromPlaylist.php.";
}

?>