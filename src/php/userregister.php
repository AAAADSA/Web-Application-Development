<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/userregister.css">
    <title>User Register</title>
</head>
<body>
<?php include('headerlogout.php'); ?>
   <?php require_once 'helper.php'?>

<?php

if(isset($_POST['register'])) {
  
    $UserName = $_POST['Name']; 
    $UserEmail = $_POST['emailLogin'];
    $UserPassword = $_POST['passwordLogin'];
    $ICNumber = $_POST['ic'];
    $PhoneNumber = $_POST['phone'];

   
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

   
    $sql = "INSERT INTO user (UserName, UserEmail, UserPassword, UserIC, UserPhone) VALUES (?, ?, ?, ?, ?)";

  
    $stmt = $con->prepare($sql);

   
    $stmt->bind_param("sssss", $UserName, $UserEmail, $UserPassword, $ICNumber, $PhoneNumber);

    
    if ($stmt->execute()) {
        
        echo "<script>alert('Registration successful.'); window.location.href = 'login.php';</script>";
        exit; // Ensure script execution stops here
    } else {
       
        $errorMessage = "Registration failed. Please try again later.";
    }

    
    $stmt->close();
    $con->close();
}
?>



<form method="post">
    <div class="grid-container">
        <div id="user_login" class="grid-item">
             <label for="username">Your Username:</label>
            <div class="input-group form-icon form-icon-username">
                <i class="fa fa-user icon"></i>
                <input type="text" name="Name" placeholder="" required>
            <label for="email">Your Email:</label>
            <div class="input-group form-icon form-icon-email">
                <i class="fa fa-envelope icon"></i>
                <input type="email" name="emailLogin" placeholder="leewenbin@gmail.com" required>
            </div>
            <label for="pwrd">Your Password:</label>
            <div class="input-group form-icon form-icon-email">
                <i class="fa fa-key icon"></i>
                <input type="password" name="passwordLogin" id="password" placeholder="*******" required>

            </div>
           
            <label for="ic">Identity Card:</label>
            <div class="input-group form-icon form-icon-email">
                <i class="fa fa-id-card icon"></i>
                <input type="text" name="ic" id="ic" placeholder="xxxxxx-xx-xxxx" required>
            </div>
            <div class="input-group form-icon form-icon-email">
                <label for="phone">Phone Number:</label>
                <i class="fa fa-phone icon"></i>
                 <input type="tel" name="phone" id="phone" placeholder="+60106565195" required>
            </div>
            
            <button type="submit" class="button" name="register">Register Now</button>
        </div>
    </div>
</form>



</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var passwordField = document.getElementById('password');
    passwordField.addEventListener('input', function() {
        var password = passwordField.value;
        var passwordLength = password.length;
        
        
        var hasUpperCase = /[A-Z]/.test(password);
        var hasLowerCase = /[a-z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        if (passwordLength < 6 || passwordLength > 12 || !hasUpperCase || !hasLowerCase || !hasNumber || !hasSymbol) {
            passwordField.setCustomValidity('Password must be 6-12 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one symbol.');
        } else {
            passwordField.setCustomValidity('');
        }
    });

    var phoneField = document.getElementById('phone');
    phoneField.addEventListener('input', function() {
        var phone = phoneField.value;
        
        var isValidPhone = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/.test(phone);
        if (!isValidPhone) {
            phoneField.setCustomValidity('Phone number must be in Malaysian format: +601XXXXXXXX');
        } else {
            phoneField.setCustomValidity('');
        }
    });

    var icField = document.getElementById('ic');
    icField.addEventListener('input', function() {
        var ic = icField.value;
     
        var isValidIC = /^\d{6}-\d{2}-\d{4}$/.test(ic);
        if (!isValidIC) {
            icField.setCustomValidity('IC number must be in the format: 123456-78-1234');
        } else {
            icField.setCustomValidity('');
        }
    });
});
</script>

