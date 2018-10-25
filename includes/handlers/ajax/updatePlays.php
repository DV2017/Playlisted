<?php
//includes/handlers/ajax/updatePlays.php

include("../../config.php");

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];
    
    //update database and increment plays based in song played
    $query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");
}
?>