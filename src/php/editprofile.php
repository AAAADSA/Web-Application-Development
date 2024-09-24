<?php

$avatarDirectory = '../avatars';
if (!file_exists($avatarDirectory)) {
    if (!mkdir($avatarDirectory, 0755, true)) {
        die('Failed to create avatar directory...');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/editprofile.css">
</head>
<body>
<?php 
include 'headermember.php'; 
require_once 'helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}


$user = $_SESSION['user'];


$successMessage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = mysqli_real_escape_string($con, $_POST['UserName']);
    $userIC = mysqli_real_escape_string($con, $_POST['UserIC']);
    $userEmail = mysqli_real_escape_string($con, $_POST['UserEmail']);
    $userPhone = mysqli_real_escape_string($con, $_POST['UserPhone']);
    
   
    $query = "UPDATE user SET UserName='$username', UserIC='$userIC', UserEmail='$userEmail', UserPhone='$userPhone' WHERE UserID=" . $user['UserID'];
    if ($con->query($query) === TRUE) {
       
        $_SESSION['user']['UserName'] = $username;
        $_SESSION['user']['UserIC'] = $userIC;
        $_SESSION['user']['UserEmail'] = $userEmail;
        $_SESSION['user']['UserPhone'] = $userPhone;
  
        $successMessage = "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $con->error;
    }
    
   
    if (isset($_FILES['Avatar']) && $_FILES['Avatar']['error'] === UPLOAD_ERR_OK) {
   
        $avatarName = $_FILES['Avatar']['name'];
        $avatarTmpName = $_FILES['Avatar']['tmp_name'];
        $avatarSize = $_FILES['Avatar']['size'];
        $avatarError = $_FILES['Avatar']['error'];
        $avatarType = $_FILES['Avatar']['type'];

       
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($avatarType, $imageTypes)) {
          
            $avatarDestination = '../avatars/' . $avatarName;
            
            if (move_uploaded_file($avatarTmpName, $avatarDestination)) {
               
                $query = "UPDATE user SET Avatar='$avatarDestination' WHERE UserID=" . $user['UserID'];
                if ($con->query($query) === TRUE) {
                    $_SESSION['user']['Avatar'] = $avatarDestination;
                } else {
                    echo "Error updating avatar: " . $con->error;
                }
            } else {
                echo "Error uploading avatar.";
            }
        } else {
            echo "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        }
    }
}
?>
<div class="edit-profile-container">
    <h2>Edit Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> <!-- enctype attribute for file upload -->
        <label for="UserName">Username:</label>
        <input type="text" id="UserName" name="UserName" value="<?php echo $user['UserName']; ?>">
        <label for="UserIC">IC:</label>
        <input type="text" id="UserIC" name="UserIC" value="<?php echo $user['UserIC']; ?>">
        <label for="UserEmail">Email:</label>
        <input type="email" id="UserEmail" name="UserEmail" value="<?php echo $user['UserEmail']; ?>">
        <label for="UserPhone">Phone:</label>
        <input type="tel" id="UserPhone" name="UserPhone" value="<?php echo $user['UserPhone']; ?>">
        <!-- Avatar upload field -->
        <label for="Avatar">Avatar:</label>
        <input type="file" id="Avatar" name="Avatar">
        <?php if (!empty($user['Avatar'])): ?>
            <img src="<?php echo $user['Avatar']; ?>" alt="Avatar" style="max-width: 200px; margin-top: 10px; display: block;">
        <?php endif; ?>
        <button type="submit">Update Profile</button>
        <?php if(!empty($successMessage)): ?>
            <p><?php echo $successMessage; ?></p>
        <?php endif; ?>
    </form>
</div>
<?php require 'footer.php'; ?>
</body>
</html>
