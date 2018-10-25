<?php
//includes/handlers/ajax/getSongJson.php

include("../../config.php");

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");
    $resultArray = mysqli_fetch_array($query);

    //echo is how to return a json variable from php via ajax
    echo json_encode($resultArray);
}

?>