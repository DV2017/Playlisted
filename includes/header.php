<?php
//includes/header.php

include("includes/config.php"); //config file needs to be the first on the page!!
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

//session_destroy(); 
//LOGOUT 

if(isset($_SESSION['userLoggedIn'])) {
    //create a new User object and pass the con and username variables
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
    $username = $userLoggedIn->getUsername();
    //store it also as a js variable for use
    echo "<script>userLoggedIn = '$username';</script>";
} else {
    header("Location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Spotify</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/jquery-3.2.1.js"></script>
    <script src="assets/js/script.js"></script>
</head>
<body>

  <div id="mainContainer">  

    <div id="topContainer">

        <?php include('includes/navBarContainer.php');?>

        <div id="mainViewContainer">
            <div id="mainContent">

<!-- the html is broken here; body is in index.php and remianin code is in footer.php -->