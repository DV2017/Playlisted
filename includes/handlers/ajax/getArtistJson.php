<?php
//includes/handlers/ajax/getArtistJson.php

include("../../config.php");

if(isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];

    $query = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");
    $resultArray = mysqli_fetch_array($query);

    //echo is how to return a json variable from php via ajax
    echo json_encode($resultArray);
}

?>