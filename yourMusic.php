<?php
//yourMusic.php

include("includes/includedFiles.php");
?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="buttonItems">
            <button  class="button green" onclick="createPlaylist()">CREATE NEW PLAYLIST</button>
        </div>

    <?php
        //get username by calling the function in User class 
        $username = $userLoggedIn->getUsername();

        //sql query with no limit of 10 or so
        $plalylistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username' ");
        
        if(mysqli_num_rows($plalylistsQuery) == 0) {
            echo "<span class = 'noResults'> You don't have any playlists yet. </span>";
        }

        while($row = mysqli_fetch_array($plalylistsQuery)){
            //see variations to this approach of passing data as object
            //class Album and Song does it differently.
            $playlist = new Playlist($con, $row);
            echo "<div class='gridViewItem' role='link' tabindex='0' 
                    onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                    <div class='playlistsImage'>
                        <img src='assets/images/icons/playlist.png'>
                    </div>
                    <div class='gridViewInfo'>"
                    . $playlist->getName() .
                    "</div>
                </div>";
        }    
    ?>

    </div> <!-- gridViewContainer-->
</div> <!-- playlistContainer -->

