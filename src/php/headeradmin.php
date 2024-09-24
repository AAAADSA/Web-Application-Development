<?php
session_start();


function isLoggedIn() {
    return isset($_SESSION['admin']);
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
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/headeradmin.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>Admin Area</title>
</head>

<body>
    <nav>
        <div class="topic">
            <h4>
                <a href="homelogout.php">Melody Maven Society 2024</a>
            </h4>
        </div>

        <div>
            <ul class="header" id="menuList">
                <li><a href="admin_add.php" class="list">Add Events</a></li>
                <li><a href="admin_view.php" class="list">View Events</a></li>
                <li><a href="manage_booking.php" class="list">Manage Booking</a></li>
                <li><a href="user_details.php" class="list">User Details</a></li>
                <li> <a href="adminprofile.php" class="list">Admin profile</a></li>
                <li><a href="headeradmin.php?logout=true" class="list">Log out</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>