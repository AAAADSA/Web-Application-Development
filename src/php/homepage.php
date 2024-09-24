<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../css/homepage.css">

</head>
<?php include 'headermember.php';
 require_once 'helper.php';
    
    $PAGE_TITLE = 'Homepage';
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
    <section class="container">
        <div class="slider-wrapper">
            <div class="slider">
                <img id="slide-1" src="../image/event1.jpg" alt/>

                <img id="slide-2" src="../image/event2.jpg" alt/>

                <img id="slide-3" src="../image/event3.jpg" alt/>
            </div>
            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
                <a href="#slide-3"></a>
            </div>
        </div>
    </section>

    <div class="wrapper">
        <img src="../image/contest.jpg" alt="">
        <div class="text-box">
            <h2>Musical Talent Contest:</h2>
            <p>Showcasing participants' musical talents, which can include solo singing competitions, instrumental performance contests, and more.</p>
        </div>
    </div>

    <div class="wrapper2">
        <img src="../image/teaching.jpg" alt="">
        <div class="text-box2">
            <h2>Music Lecture:  </h2>
            <p>Music Lecture: Inviting professional musicians or scholars to give lectures on topics such as music history, theory, composition, and more."</p>
        </div>
    </div>
</body>
<?php include 'footer.php';?>
</html>