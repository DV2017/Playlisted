<?php
//search.php

include("includes/includedFiles.php");

/*get keyword from url into variable
url data is got with GET. */
if(isset($_GET['term'])) {
    //decode - eg: deepa varma in url = deepa%20varma
    //decode url so that user spaces are retained;
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}
?>

<!-- search input container -->
<div class="searchContainer">
    <h4>Search for an artist song or album </h4>
    <!-- text box value is retained dynamically -->
    <!-- onfocus refocuses cursor to current position-->
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="type your search here..." onfocus="this.value = this.value" >
</div> <!--searchContainer-->

<script>
/*take value of input field and puts it into url with a timeout function
then do a search function
it can be done with ajax too..*/ 

$(function() {
    //brings focus to input field
    //but problem is focus shifts to beginning of field
    //modify input field with onfocus
    $(".searchInput").focus();

    $(".searchInput").keyup(function(){
        //time is reset everytime uer types a character
        clearTimeout(timer);

        //if idle for 2000millisecs, page is reloaded
        timer = setTimeout(function() {
            //takes value typed in
            var val = $(".searchInput").val();
            //GET searches for 'term'; see above code
            //loads the page; note that focus on input is lost
            // when page is loaded; refocus 
            openPage("search.php?term=" + val);
        }, 2000);
    });

});

</script>

<?php if($term == "") { exit(); } ?>

<div class="tracklistContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">
    
    <?php
        $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%'");

        if(mysqli_num_rows($songsQuery) == 0) {
            echo "<span class = 'noResults'> There are no songs matching '" . $term . "'.</span>";
        }

        $songIdArray = array();
        
        $i=1;
        while($row = mysqli_fetch_array($songsQuery)) {
            
            //limits artist songs to only 5. ofcourse this is a choice
            if($i > 15) {
                break;
            }
            //id is from the songs table
            array_push($songIdArray, $row['id']);

            $albumSong = new Song($con, $row['id']);
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
</div>



<div class="artistsContainer borderBottom">
    <h2>ARTISTS</h2>

    <?php
    $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '%$term%' LIMIT 10");
    
    if(mysqli_num_rows($artistsQuery) == 0) {
        echo "<span class = 'noResults'> There are no artists matching '" . $term . "'.</span>";
    }
    
    while($row = mysqli_fetch_array($artistsQuery)) {
        $artistFound = new Artist($con, $row['id']);

        echo "<div class='searchResultRow'>
                <div class='artistName'>
                    <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . " \")'>  
                    ". $artistFound->getName()."
                    </span>
                </div>
            </div>";
    }
    ?>
</div>

<div class="gridViewContainer">
    <h2>ALBUMS</h2>    
    <?php
        //sql query with no limit of 10 or so
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '%$term%' LIMIT 10");
        
        if(mysqli_num_rows($albumQuery) == 0) {
            echo "<span class = 'noResults'> There are no albums matching '" . $term . "'.</span>";
        }

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