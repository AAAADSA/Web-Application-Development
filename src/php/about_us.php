<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" type="text/css" href="../css/about_us.css">
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
    <section class="about">
        <div class="main">
            <img src="../image/MMS.jpg" alt="Melody Maven Society">
            <div class="about-text">
                <h1>About Us</h1>
                <p>Melody Maven is not just a society; it's a crescendo of musical experiences, where rhythm meets community. From captivating music lectures that enlighten the mind to exhilarating music competitions that ignite the spirit, we orchestrate a symphony of events that cater to every musical soul.</p>
                <p>Dive into our world and immerse yourself in the harmony of our music runs, where every step resonates with the beat of your heart. Feel the thrill of our music competitions, where talents collide and creativity flourishes.</p>
                <p>And don't miss our breathtaking concerts, where melodies weave tales and emotions echo through the air. At Melody Maven, we don't just listen to music; we live it. Join us on this melodious journey, where every note strikes a chord and every moment is a masterpiece.</p>
                  <a href="feedback.php" class="feedback"><button id="feedback">Send Feedback About Society</button></a>


            </div>
        </div>
    </section>
</body>
<?php
include('footer.php');
?>
</html>