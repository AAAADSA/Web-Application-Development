<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Payments</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #D3D3D3;
        }

        .container {
            text-align: center;
            margin-top: 100px;
            border: 5px solid black;
            border-radius: 5px;
            margin-bottom: 40px; 
            padding-bottom: 100px; 
            max-width: 600px; 
            margin-left: auto; 
            margin-right: auto; 
           background-color: snow;
        }

        h1 {
            padding-top: 40px;
            color: darkblue;
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        .countdown {
            color: black;
            font-size: 20px;
            margin-top: 20px;
        }

        .links-container {
            margin-top: 20px;
            display: inline-block;
            padding: 10px;
            color: black;
        }

        .links-container a {
            display: block;
            margin-bottom: 10px;
            color: black;
        }

        .links-container a:hover {
            display: block;
            margin-bottom: 10px;
            color: yellowgreen;
        }
    </style>
</head>
<body>
    <?php include 'headermember.php'; ?>
    <?php require_once 'helper.php';?>
    
    <?php
 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $id_card = isset($_POST['id_card']) ? $_POST['id_card'] : '';

       
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        
        $sql = "INSERT INTO user (UserEmail, UserName, UserPhone, UserIC) VALUES ('$email', '$name', '$phone', '$id_card')";

       
        if ($con->query($sql) === TRUE) {
            // 显示从 POST 请求中获取的数据
            echo "<div class='container'>";
            echo "<h2>Inserted Data:</h2>";
            echo "<p>Email: $email</p>";
            echo "<p>Name: $name</p>";
            echo "<p>Phone: $phone</p>";
            echo "<p>ID Card: $id_card</p>";
            echo "</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
        
   
        $con->close();
    }
    ?>


    <div class="container">
        <?php
            echo "<h1>Booking completed!</h1>";
        ?>
        
        <div class="links-container">
            <h2><a href="events.php">Back to Events</a></h2>
            <h2><a href="homepage.php">Back to Home</a></h2>
        </div>
        <div class="countdown" id="countdown"></div>
    </div>

    <script>
        
        var countdownTime = 10;
        

        function updateCountdown() {
            document.getElementById("countdown").innerHTML = "Redirecting to events page in " + countdownTime + " seconds...";
            countdownTime--;
            if (countdownTime < 0) {
                window.location.href = 'events.php';
            } else {
                setTimeout(updateCountdown, 1000);
            }
        }
        
       
        updateCountdown();
    </script>
</body>
</html>