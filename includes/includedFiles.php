<?php
//included/includedFiles.php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    //this indicates ajax request
    //thus openPage() called through ajax is created through ajax
     
    include("includes/config.php"); //config file needs to be the first on the page!!
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");

    //header and footer php is not a part of this call
    //header sets the userLoggedIn information
    //get this variable here
    if(isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    } else {
        echo "Username variable was not passed into the page. Check openPage() in script.js";
        exit();
    }

} else {
    include("includes/header.php");
    include("includes/footer.php");

    $url = $_SERVER['REQUEST_URI']; 
    echo "<script>openPage('$url');</script>";
    exit();
}

?>