<?php
//includes/nowPlayingBar.php
//lecture 85: create a playlist when the footer loads; get all song ids from database
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10" );
$resultArray = array();

while($row = mysqli_fetch_array($songQuery)){
    array_push($resultArray, $row['id']);
}
//converting php variables to json for use in javascript to play songs
$jsonArray = json_encode($resultArray);
?>

<script>
//use the php playlist array into the nowPlayingBar using the playlist variable from js
$(document).ready(function() {
    var newPlaylist = <?php echo $jsonArray; ?>;
    //console.log(currentPlaylist);
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);
    
    /*to prevent mouse action outside designated areas; to prevent random selection of objects, text*/
    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
        e.preventDefault();
    });

    //dynamicaally move audio progress bar based on mouse click
    $(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
    });
    
    //set time of song depending on position of mouse
    //'this' is the html element with class progressBar
    //e is the mouse event
    $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
            timeFromOffset(e, this);
        }
    });

    $(".playbackBar .progressBar").mouseup(function(e) {
        timeFromOffset(e, this);
        mouseDown = false;
    });
    /* as in udemy course; but it works when added to the previous mouseup function
    $(document).mouseup(function(){
        mouseDown = false;
    });
    */
    //Volume controls
    $(".volumeBar .progressBar").mousedown(function() {
        mouseDown = true;
    });
    
    $(".volumeBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <=1 ) {
                audioElement.audio.volume = percentage;
            }   
        }
    });

    $(".volumeBar .progressBar").mouseup(function(e) {
        var percentage = e.offsetX / $(this).width();
        if(percentage >= 0 && percentage <=1 ) {
            audioElement.audio.volume = percentage;
        }
        mouseDown = false;
    });
});

function timeFromOffset(eventMouse, progressBar){
    var percentWidth = eventMouse.offsetX / $(progressBar).width();
    var progressedTime = audioElement.audio.duration * percentWidth;
    //set progressed time to be the current time - in the js file
    audioElement.setTime(progressedTime);
}

function nextSong() {
    if(repeat == true) {
        audioElement.setTime(0);
        playSong(); 
        return;
    }

    //increment key of the songId to the next in the current playlist
    if(currentIndex == currentPlaylist.length - 1) {
        currentIndex = 0;
    } else {
        currentIndex++;
    }
    //setTrack to new index
    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
    //true indicates autoplay;
    //but safari does not support autoplay
}

function setRepeat() {
    //repeat = !repeat
    //var imgRepeat = repeat ? "repeat-active.png" : "repeat.png"
    if (repeat == false) {
        repeat = true;
        var imageName = "repeat-active.png";
    } else{
        repeat = false;
        var imageName = "repeat.png";
    }
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function prevSong() {
    if(audioElement.audio.currentTime >= 3 || currentIndex == 0 || repeat == true) {
        audioElement.setTime(0);
        //already playing; so no need to setTrack again
    } else {
        currentIndex--;
        //setTrack to new index
        var trackToPlay = currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }
    
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

//user calls for a shuffle toggle
function setShuffle() {
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

    if(shuffle == true) {
        //randomise playlist
        shuffleArray(shufflePlaylist);
        //set index of currently playing song as current index of shuffled list
        //this prevents same song from playing again if list is shuffled 
        currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
        //no shuffle
        //go back to previous playlist
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
}

//shuffles an array - The Fisher–Yates shuffle in js
function shuffleArray(array) {
    var j, x, i;
    for (i = array.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = array[i];
        array[i] = array[j];
        array[j] = x;
    }
}

//set the track in the nowPlayingBar when the page has finished loading
function setTrack(trackId, newPlaylist, play) {

    //if user selects a new play/album and thus has a new playlist 
    if(newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        /*a copy of this is sent for shuffling if user presses shuffle button;
        making a copy allows going back to the newPlaylist if user deactivates shuffle */
        shufflePlaylist = currentPlaylist.slice();
        //this ensures shuffle playlist when user changes playlist
        shuffleArray(shufflePlaylist);
    }
    /*when user changes playlist, a check for shuffle is made. If checked
    the new playlist on album page is also shuffled */
    if(shuffle == true) {
        currentIndex = shufflePlaylist.indexOf(trackId);
    } else {
        currentIndex = currentPlaylist.indexOf(trackId);
    }
    
    //pauses the currently playing when user makes changes
    pauseSong(); 

    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data){
        var track = JSON.parse(data);

        //changing html class with jquery .text()
        $(".trackName span").text(track.title);

        //based on artistId in track data, calling ajax to retrieve artist information
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data){
            var artist = JSON.parse(data);
            //changing html class with jquery .text(); make the selector very specific
            $(".trackInfo .artistName span").text(artist.name);
            //when artist in nowPlayingBar is clicked, opens the artist's page
            $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id +"')");
        });

        //based on albumId in track data, calling ajax to retrieve album information
        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data){
            var album = JSON.parse(data);
            //changing html class with jquery .text()
            $(".content .albumLink img").attr("src", album.artworkpath);
            //when album image/song name in nowPlayingBar is clicked, opens the album page
            $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id +"')");
            $(".content .trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id +"')");
        });

        //call functions of Audio class in script.js
        audioElement.setTrack(track); 
        if(play == true){
        playSong();  
    }    
    });
}

//pause and play functionality in the Playing Bar bottom of page
function playSong(){
    //console.log(audioElement); click play in the browser 
    //check console for 'audio' properties: currentTime
    //this section updates audioElement.audio.currentTime
    if (audioElement.audio.currentTime == 0) {
        //console.log("UPDATE TIME"); testing
        //make an ajax call to set it
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong(){
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

</script>


<div id="nowPlayingBarContainer">
  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
        <div class="content">
            <span class="albumLink">
                <img role="link" tabindex="0" src="" class="albumArtwork" alt="now playing song">                        
            </span>

            <!-- track and artist name is added dynamically in span by setTrack(x,x,x)-->
            <div class="trackInfo">
                <span class="trackName">
                    <span role="link" tabindex="0"></span>
                </span>
                <span class="artistName">
                    <span role="link" tabindex="0"></span>
                </span>
            </div><!--trackInfo-->       
        </div> <!--content-->
    </div> <!--nowPlayingleft-->
            
    <div id="nowPlayingCenter">

        <div class="content playerControls">
            <div class="buttons">

                <button class="controlButton shuffle" title="shuffle" onclick="setShuffle()">
                    <img src="assets/images/icons/shuffle.png" alt="shuffle button">
                </button>

                <button class="controlButton previous" title="previous" onclick="prevSong()">
                    <img src="assets/images/icons/previous.png" alt="previous button">
                </button>

                <button class="controlButton play" title="play" onclick="playSong()">
                    <img src="assets/images/icons/play.png" alt="play button">
                </button>
                <button class="controlButton pause" title="pause" style="display: none;" onclick="pauseSong()">
                    <img src="assets/images/icons/pause.png" alt="pause button">
                </button>

                <button class="controlButton next" title="next" onclick="nextSong()">
                    <img src="assets/images/icons/next.png" alt="next button">
                </button>

                <button class="controlButton repeat" title="repeat" onclick="setRepeat()">
                    <img src="assets/images/icons/repeat.png" alt="repeat button">
                </button>

            </div> <!-- buttons -->

            <div class="playbackBar">
                <span class="progressTime current">0.00</span>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div> <!-- progressBar-->
                <span class="progressTime remaining">0.00</span>
            </div> <!-- playbackBar -->

        </div> <!-- content playerControls -->
        
    </div> <!--nowPlayingCenter-->

    <div id="nowPlayingRight">
        <div class="volumeBar">
            <button class="controlButton volume" title="volume button" onclick="setMute()">
                <img src="assets/images/icons/volume.png" alt="volume">
            </button>

            <div class="progressBar">
                <div class="progressBarBg">
                    <div class="progress"></div>
                </div>
            </div> <!-- progressBar-->
        </div><!--volumeBar -->
    </div> <!--nowPlayingRight-->

  </div> <!--nowPlayingBar-->
</div> <!-- nowPlayingBarContainer -->