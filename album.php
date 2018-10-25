<?php 
//album.php
include("includes/includedFiles.php");

if(isset($_GET['id'])){
    $albumId = $_GET['id'];                 //use GET to get id from url
} else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);         
//Album.php : create new class object and passed on the GET details
$artist = $album->getArtist();              
//Artist.php : call only object function. The class already created in Album.php 
$artistId = $artist->getId();
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtWorkPath();?>" alt="artwork image">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle();?></h2>
        <p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></p>
        <p>Songs in the album: <?php echo $album->getNumberOfSongs();?></p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
    
        <?php
            $songIdArray = $album->getSongIds(); //get all artists for the album; there can be more than 1 artist
            $i=1;

            foreach($songIdArray as $songId) {
                
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
</nav>
