<?php
//includes/handlers/ajax/getAlbumJson.php

include("../../config.php");

if(isset($_POST['albumId'])) {
    $albumId = $_POST['albumId'];

    $query = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
    $resultArray = mysqli_fetch_array($query);

    //echo is how to return a json variable from php via ajax
    echo json_encode($resultArray);
}

?>