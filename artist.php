<?php
//artist.php
include("includes/includedFiles.php");
    
if(isset($_GET['id'])){
    $artistId = $_GET['id'];                 //use GET to get id from url
} else {
    header("Location: index.php");
}

$artist = new Artist($con, $artistId);      //create new object of class
?>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getName();?></h1>
            <div class="headerButtons">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>
        </div><!-- artistInfo  -->
    </div> <!-- centerSection -->
</div> <!-- entityInfo -->

<div class="tracklistContainer borderBottom">
    <h2>SONGS: 5 MOST POPULAR</h2>
    <ul class="tracklist">
    
    <?php
        $songIdArray = $artist->getSongIds(); //get all artists for the album; there can be more than 1 artist
        
        $i=1;
        
        foreach($songIdArray as $songId) {
            
            //limits artist songs to only 5. ofcourse this is a choice
            if($i > 5) {
                break;
            }

            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();
            /* when retrieving trackId in setTrack use \" to set the Id in quotes */
            echo "
                <li class='tracklistRow'>
                    <div class='trackCount'>
                    <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", userPlaylist, true)'>
                    <span class='trackNumber'>$i</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>" . $albumSong->getTitle() . "</span>
                        <span class='artistName'>" . $albumArtist->getName() . "</span>
                    </div>

                    <div class='trackOptions'>
                        <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                        <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                    </div>

                    <div class='trackDuration'>
                        <span class='duration'>" . $albumSong->getDuration() . "</span>
                    </div>
                </li>
            ";

            $i++;
        }
    ?>
        
    <script>
        //stores json array; use single quotes; to send to script.js 
        var thisAlbumSongId = '<?php echo json_encode($songIdArray); ?>' ; 
        userPlaylist = JSON.parse(thisAlbumSongId); //makes js object
        
    </script>
    </ul>
</div> <!-- tracklistContainer-->

<div class="gridViewContainer">
    <h2>ALBUMS</h2>    
    <?php
        //sql query with no limit of 10 or so
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId' ORDER BY title ASC");

        while($row = mysqli_fetch_array($albumQuery)){
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id']. "\")' >
                    <img src='"  .$row['artworkpath']. "'>
                    <div class='gridViewInfo'>"
                    .$row['title'].
                    "</div>  
                    </span>  
                </div>";
        }
        
    ?>
</div>

<!-- creating options menu -->
<nav class="optionsMenu">
    <input type="hidden" class="songId" >
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>