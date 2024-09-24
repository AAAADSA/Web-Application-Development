<?php
session_start();


function isLoggedIn() {
    return isset($_SESSION['user']);
}


function logout() {
  
session_destroy();
   
    header("Location: homelogout.php");
    exit;
}


if (isset($_GET['logout'])) {
    logout();
}


if (!isLoggedIn()) {
    logout();
}

?>

<!DOCTYPE html>
<html lang="en">

<head class="headDesign">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/headermember.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
    <nav>
        <div class="topic">
            <h4>
                <a href="homepage.php">Melody Maven Society 2024</a>
            </h4>
        </div>

        <div>
            <ul class="header" id="menuList">
                <?php
             
                if (isLoggedIn()) {
                    echo "<li><a href='homepage.php' class='list'>Home</a></li>";
                    echo "<li><a href='events.php' class='list'>Events</a></li>";
                    echo "<li><a href='about_us.php' class='list'>About us</a></li>";
                    echo "<li><a href='viewprofile.php' class='list'>Profile</a></li>";
                    echo "<li><a href='userevent.php' class='list'>Your Event</a></li>";
                    echo "<li><a href='headermember.php?logout=true' class='list'>Log out</a></li>";
                }
                ?>
                <li class="search-container">
                    <form action="search.php" method="GET">
                        <input type="text" name="search" placeholder="Search...">
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>