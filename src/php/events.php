<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/event1.css">
    <title>Events</title>
</head>

<?php include 'headermember.php';
 require_once 'helper.php';
    
    $PAGE_TITLE = 'About Us';
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
    

    $user = $_SESSION['user'];
 ?>
<body>
    <div class="event">
        <?php
        
        $event_data = array(
            array(
                "image" => "../image/Concert.jpeg",
                "title" => "Concert",
                "link" => "http://localhost/G11_MELODYMAVENSOCIETY/php/concert.php"
            ),
            array(
                "image" => "../image/MMSRUN.png",
                "title" => "MMS Run",
                "link" => "http://localhost/G11_MELODYMAVENSOCIETY/php/mms_run.php"
            ),
            array(
                "image" => "../image/musiccompetition.jpg",
                "title" => "Music Competition",
                "link" => "http://localhost/G11_MELODYMAVENSOCIETY/php/musiccompetition.php"
            ),
            array(
                "image" => "../image/musiclecture.jpg",
                "title" => "Music Lecture",
                "link" => "http://localhost/G11_MELODYMAVENSOCIETY/php/musiclecture.php"
            ),
            array(
                "image" => "../image/comingsoon.jpg",
                "title" => "Coming Soon!!!",
                "link" => "http://localhost/G11_MELODYMAVENSOCIETY/php/comingsoon.php",
                "hide_button" => true
            )
        );

       
        foreach ($event_data as $data) {
            echo "<div class='event-item'>";
            echo "<div class='image-container'>";
            echo "<a href='" . ($data['link'] ? $data['link'] : '#') . "'>"; 
            echo "<img src='" . $data['image'] . "' alt='" . $data['title'] . "'>";
            echo "<div class='title'>" . $data['title'] . "</div>"; 
            echo "</a>";
            
          
            if (!isset($data['hide_button']) || !$data['hide_button']) {
                echo "<a href='" . $data['link'] . "' class='register-button'>Register Now</a>";
            }
            
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    
    <?php require 'footer.php'; ?>
</body>
</html>
