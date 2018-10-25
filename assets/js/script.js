//javascript to play songs; assets/js/register.js

var currentPlaylist = []; //array for songIds 
var shufflePlaylist = []; //array to hold shuffled songIds
var userPlaylist = []; //array to hold songIds from user selected
var audioElement; 
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).click(function(click){
    /*add click event to anywhere in the document
    //if anywhere other than item or optionsButton classes, 
    the function is called */
    var target = $(click.target);
    if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

$(window).scroll(function(){
    //every time window scrolls the optionsMenu hides if it is visible
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function(){
    //function is called everytime playlist in optionsMenu is changed by user selection
    //this is the playlist option element which holds the playlistId
    var select = $(this);
    var playlistId = select.val();
    //pick value of songId from optonsMenu using prev DOM with songId class.
    //takes the immediate ancestor
    var songId = select.prev(".songId").val();
    //this value is only dynamcally added in the showOptionsMenu()
    console.log(songId);
    console.log(playlistId);
    //post ajax call to insert data into db
    $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId : playlistId, songId : songId})
    .done(function(error){

        if(error != "") {
            //error != null leaves a blank box behind
            alert(error);
            return;
        }
        console.log(songId);
        console.log(playlistId);
        hideOptionsMenu();
        //this handles optionsMenu value refresh;
        select.val("");
    });
}); 

function logout(){
    $.post("includes/handlers/ajax/logout.php", function(){
        location.reload();
    });
}

function updateEmail(emailClass) {
    //email sent as onclick from updateDetails.php
    var emailValue = $("." + emailClass).val();
    //ajax post to update email
    $.post("includes/handlers/ajax/updateEmail.php", { email : emailValue, username : userLoggedIn })
    .done(function(response){
        //update span element with response
        $("." + emailClass).nextAll(".message").text(response);
        //nextAll finds matching elements in siblings 
    });
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    // sent as onclick from updateDetails.php
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();
    //ajax post to update email
    $.post("includes/handlers/ajax/updatePassword.php", 
    { 
        oldPassword : oldPassword, 
        newPassword1 : newPassword1,
        newPassword2 : newPassword2,
        username : userLoggedIn 
    }).done(function(response){
        //update span element with response
        $("." + oldPasswordClass).nextAll(".message").text(response);
        //nextAll finds matching elements in siblings 
    });
}

function openPage(url) {
    //this function attempts to ajax reload the page
     
    /*1st it invalidates timer overruns with search.php
    timer overrun can happen if user starts a search 
    but in <2 secs moves to another page. this the kills it*/
    if(timer != 0) {
        clearTimeout(timer);
    }
    //it first takes the url, checks for ? sign
    //the ? sign is the first after the php file extn. - like this xxx.php?
    //then comes the & and the other details
    //then it loads the url into the mainContent container.
    if(url.indexOf("?") == -1) {
        url = url + "?";
    }
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0); //scrolls to the top everytime a new page loads
    history.pushState(null, null, url);
    /*a situation is that the url does not change when user changes page. 
    this is because they are ajax calls. this will show the url in the address bar
    what this also does is it creates a full main content with headers and footers.
    so the file structure is reshaped in includedFiles.php. 
    so 
    */
}
function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();
    //ajax post call
    $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId : playlistId, songId : songId })
    .done(function(error){

        if(error != "") {
            //error != null leaves a blank box behind
            alert(error);
            return;
        }
        
        openPage("playlist.php?id=" + playlistId); 
    });    
}

function createPlaylist() {
    var playlistPopup = prompt("Type the name of your playlist");
    if(playlistPopup != null) {
        //if user clicks ok playlistPopup is not null;
        //send ajax post request to a file that performs the create playlist function
        $.post("includes/handlers/ajax/createPlaylist.php", { name: playlistPopup, username: userLoggedIn })
        .done(function(error){
            if(error != "") {
                //error != null leaves a blank box behind
                alert(error);
                return;
            } else {
                alert("Playlist created successfully");
                openPage("yourMusic.php"); 
                /*a page refreshes with newly added playlist
                done() for ajax responses : deferreds - read more
                can also do success handlers. but .done() preferred
                posts data within {} to this php url */
            }
        });    
    }
}

function deletePlaylist(playlistId) {
    var deletePrompt = confirm("Are you sure you want to delete the playlist?");
    if(deletePrompt) {
        //if user selects ok, prompt is true;
        //send ajax post request to a file that performs the delete playlist function
        $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId : playlistId })
        .done(function(error){
            if(error != "") {
                //error != null leaves a blank box behind
                alert(error);
                return;
            } else {
                alert("Playlist deleted successfully");
                openPage("yourMusic.php");
            }
        }); 
    }
}

function hideOptionsMenu() {
    //sets element's display property to none
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
        //now call this function in the window.scroll on the top of this page
    }
}

//showing 'add to playlist' menu on clicking optionsButton in tracklist
function showOptionsMenu(button) {

    //getting the songsId = 1st  songId ancestor to the optionButton class.
    var songId = $(button).prevAll(".songId").val();
    var menu = $(".optionsMenu");

    //looks for class songId in optionsMenu class i.e, the input element and 
    //assigns the value of songId.
    //this is then picked up when playlist change event is fired: see .on(change, ,)
    menu.find(".songId").val(songId);

    //set position of optionsMenu relative to optionsButton
    var menuWidth = menu.width();
    var scrollTop = $(window).scrollTop(); //distance from top of current window to top of document
    var elementOffset = $(button).offset().top; //offset gets position of element to top of document
    var top = elementOffset - scrollTop;
    var position = $(button).position().left; //current coordinates of options element relative to parent
    //element.left gives the left of the position
    var left = position - menuWidth; //places the position left, equal to the menu width
     
    menu.css({ "top" : top + "px", "left" : left + "px", "display" : "inline" });

}


//scripting the nowplayingbar 

//time function on 0:00
function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); //rounds to the number
    var seconds = time - (minutes * 60); //takes the remaining in seconds

    //if statement in shorthand
    var extraZero = (seconds < 10) ? "0" : ""; //to get the 0 in the format, say 8 min 5 secs
    
    return minutes + ":" + extraZero + seconds;
}

//update audio play progress bar
function updateTimeProgressBar(audio){
    //increment begin time
    var progressTime = formatTime(audio.currentTime);
    $(".progressTime.current").text(progressTime);
    //decrement end time
    var timeRemaining = formatTime(audio.duration - audio.currentTime);
    $(".progressTime.remaining").text(timeRemaining);
    //move progress bar by css attribute width set to percentage
    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%" );
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100; //to get the %
    $(".volumeBar .progress").css("width", volume + "%" );
}

function playFirstSong() {
    setTrack(userPlaylist[0], userPlaylist, true);
}   

function Audio() {
    //create a new class called Audio
    //create new property; no value assigned
    this.currentlyPlaying;

    //new proerty called audio; 
    //also creates a new element in the main document called audio and 
    //is assigned to new property audio.
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function(){
        nextSong();
    });

    //add formatted track duration of the song being played
    this.audio.addEventListener("canplay", function(){
        //this refers to the object the event is added to: audio
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    //change display time based on audio.currentTime
    this.audio.addEventListener("timeupdate", function(){
        if(this.duration) {
            //calls only if audio has duration, ie. in play mode
            //when audio is paused function is not called.
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);   
    });

    //define a method to set the track based on its source;
    //keep track of the play time everytime the song is played
    this.setTrack = function(track){
        this.currentlyPlaying = track;
        //the function takes the source and assigns it to the audio element.
        this.audio.src = track.path;
    }

    //audioElement.audio.play();
    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    //sets the time to the time received by the function
    this.setTime = function(time) {
        this.audio.currentTime = time;
    }
}