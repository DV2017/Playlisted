<?php
//index.php 
include("includes/includedFiles.php");
?>

<!-- only the 'body' part of the webpage design (main content)-->

<!-- the udemy course made the index page same as browse page. so the whole section below was copied and pasted to browse.php
And in this section the openPage('browse.php') function was called within script tags with browse.php passed into it.
<script>openPage("browse.php")</script> you dont need a semicolon after openpage()

but this need not be the case. I can also use this to show albums differently, or not limit to 10 etc
So I have used this page to show all songs in ascending order with limit 10 -->

<h1 class="pageHeadingBig">Music sound track</h1>
<div class="gridViewContainer">

<?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

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

