<?php 
//browse.php
include("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">Music sound track</h1>
<div class="gridViewContainer">

<?php
    //sql query with no limit of 10 or so
    $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY title ASC");

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