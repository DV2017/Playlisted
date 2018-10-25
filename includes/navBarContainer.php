<!--includes/navBarContainer.php -->
<div id="navBarContainer">

    <nav class="navBar">

        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="logo">
        </span>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">Search
                    <img src="assets/images/icons/search.png" alt="Search" class="searchIcon">
                </span>
            </div>
        </div> <!-- group -->        

        <div class="group">
            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
            </div>

            <div class="navItem">
            <span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>

        </div> <!--group -->

    </nav>
</div> <!-- navBarContainer-->        