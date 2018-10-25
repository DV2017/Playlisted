<?php 
//playlist.php

    include("includes/includedFiles.php");
    

    if(isset($_GET['id'])){
        $playlistId = $_GET['id'];                 //use GET to get id from url
    } else {
        header("Location: index.php");
    }
    
    $playlist = new Playlist($con, $playlistId); 
    $owner = new User($con, $playlist->getOwner());        
?>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png">
        </div>
    </div>
    <div class="rightSection">
        <h2><?php echo $playlist->getName();?></h2>
        <p>By <?php echo $playlist->getOwner();?></p>
        <p>Songs: <?php echo $playlist->getNumberOfSongs();?></p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId; /*from above*/?>')">DELETE PLAYLIST</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
    
        <?php
            $songIdArray = $playlist->getSongIds();
            $i=1;

            foreach($songIdArray as $songId) {
                //creating all the songs in the playlist
                //just like in album.php
                $playlistSong = new Song($con, $songId);
                $songArtist = $playlistSong->getArtist();
                /* when retrieving trackId in setTrack use \" to set the Id in quotes */
                echo "
                    <li class='tracklistRow'>
                        <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", userPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                            <span class='artistName'>" . $songArtist->getName() . "</span>
                        </div>

                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <span class='duration'>" . $playlistSong->getDuration() . "</span>
                        </div>
                    </li>";
                $i++;
            }
        ?>
        
        <script>
            //stores json array; use single quotes
            var thisAlbumSongId = '<?php echo json_encode($songIdArray); ?>' ; 
            userPlaylist = JSON.parse(thisAlbumSongId); //makes js object   
        </script>
    </ul>
</div>

<!-- creating options menu -->
<nav class="optionsMenu">
    <input type="hidden" class="songId" >
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove From Playlist</div>
</nav>