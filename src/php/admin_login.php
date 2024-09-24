<?php
    session_start();

    include('headerlogout.php');
    require_once('helper.php');

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    
    if(isset($_POST['login'])) {
        
        $AdminID = $_POST['adminID']; 
        $Password = $_POST['passwordLogin'];

  
        $sql = "SELECT * FROM admin WHERE AdminID = ? AND Password = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $AdminID, $Password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            $_SESSION['admin'] = $admin;

            header("Location:admin_add.php"); 
            exit;
        } else {
            $errorMessage = "AdminID or password invalid. Please try again"; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login1.css">
    <title>Admin Login</title>
</head>
<body>
    <form method="post">
        <div class="grid-container">
            <div id="user_login" class="grid-item">
                <label for="adminID">Admin ID:</label> 
                <div class="input-group form-icon form-icon-email">
                    <i class="fa fa-envelope icon"></i>
                    <input type="text" name="adminID" placeholder="Admin ID" required> 
                </div>
                <label for="pwrd">Your Password:</label>
                <div class="input-group form-icon form-icon-email">
                    <i class="fa fa-key icon"></i>
                    <input type="password" name="passwordLogin" id="password" placeholder="*******" required>
                </div>
                <button type="submit" class="button" name="login">Log In</button>
                <?php if(isset($errorMessage)) { ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php } ?>
            </div>
            
        </div>
    </form>
    <?php require 'footer1.php'; ?>
</body>
</html>
