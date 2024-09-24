<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link type="text/css" href="../css/feedback.css" rel="stylesheet">
</head>
<body>
    <?php 
    include 'headermember.php';
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


$errorMessages = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['feedback'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $feedback = $_POST['feedback'];
        $phone = $_POST['phone'];
        $ic = $_POST['ic'];

        // Perform validation checks after variables have been set
        if(!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errorMessages['name'] = 'Name should contain only letters and whitespace.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages['email'] = 'Invalid email format.';
        }
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $errorMessages['phone'] = 'Phone number should contain 10 digits.';
        }
        if (!preg_match("/^\d{6}-\d{2}-\d{4}$/", $ic)) {
            $errorMessages['ic'] = 'IC number must be in the format: 123456-78-1234.';
        }

        if(empty($errorMessages)) {
            $sql = "INSERT INTO user (UserName, UserEmail, UserComment, UserPhone, UserIC) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssss", $name, $email, $feedback, $ic, $phone);

            if ($stmt->execute()) {
                echo '<span style="color: green;">Feedback submitted successfully.</span>';
            } else {
                echo '<span style="color: red;">Error: ' . $stmt->error . '</span>';
            }

            $stmt->close();
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<div class="container">
    <h2>Customer Feedback Form</h2>
    <form action="#" method="post">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>
        <?php if(isset($errorMessages['name'])) echo '<span style="color: red;">'.$errorMessages['name'].'</span>'; ?>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>
        <?php if(isset($errorMessages['email'])) echo '<span style="color: red;">'.$errorMessages['email'].'</span>'; ?>

        <label for="phone">Your Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <?php if(isset($errorMessages['phone'])) echo '<span style="color: red;">'.$errorMessages['phone'].'</span>'; ?>

        <label for="ic">Your IC:</label>
        <input type="text" id="ic" name="ic" required>
        <?php if(isset($errorMessages['ic'])) echo '<span style="color: red;">'.$errorMessages['ic'].'</span>'; ?>

        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="6" required></textarea>
        
        <input type="submit" value="Submit Feedback">
    </form>
</div>

    <?php include('footer.php'); ?>
</body>
</html>