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

include 'headeradmin.php';
require_once 'helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$admin = $_SESSION['admin'];


$successMessage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $adminName = mysqli_real_escape_string($con, $_POST['AdminName']);
    $adminEmail = mysqli_real_escape_string($con, $_POST['AdminEmail']);
    $adminPhone = mysqli_real_escape_string($con, $_POST['AdminPhone']);

  
    $avatarDirectory = '../avatars';
    if (!file_exists($avatarDirectory)) {
        if (!mkdir($avatarDirectory, 0755, true)) {
            die('Failed to create avatar directory...');
        }
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
              
                $adminAvatar = $avatarDestination;
                $query = "UPDATE admin SET AdminName='$adminName', Email='$adminEmail', Phone='$adminPhone', Avatar='$adminAvatar' WHERE AdminID=" . $admin['AdminID'];
                if ($con->query($query) === TRUE) {
                    $_SESSION['admin']['AdminName'] = $adminName;
                    $_SESSION['admin']['Email'] = $adminEmail;
                    $_SESSION['admin']['Phone'] = $adminPhone;
                    $_SESSION['admin']['Avatar'] = $adminAvatar;
                    $successMessage = "Profile updated successfully!";
                } else {
                    echo "Error updating profile: " . $con->error;
                }
            } else {
                echo "Error uploading avatar.";
            }
        } else {
            echo "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        }
    } else {
    
        $query = "UPDATE admin SET AdminName='$adminName', Email='$adminEmail', Phone='$adminPhone' WHERE AdminID=" . $admin['AdminID'];
        if ($con->query($query) === TRUE) {
            $_SESSION['admin']['AdminName'] = $adminName;
            $_SESSION['admin']['Email'] = $adminEmail;
            $_SESSION['admin']['Phone'] = $adminPhone;
            $successMessage = "Profile updated successfully!";
        } else {
            echo "Error updating profile: " . $con->error;
        }
    }
}
?>
<div class="edit-profile-container">
    <h2>Edit Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> <!-- Added enctype attribute -->
        <input type="hidden" name="AdminID" value="<?php echo $admin['AdminID']; ?>">
        <label for="AdminName">Admin Name:</label>
        <input type="text" id="AdminName" name="AdminName" value="<?php echo $admin['AdminName']; ?>">
        <label for="AdminEmail">Email:</label>
        <input type="email" id="AdminEmail" name="AdminEmail" value="<?php echo $admin['Email']; ?>">
        <label for="AdminPhone">Phone:</label>
        <input type="tel" id="AdminPhone" name="AdminPhone" value="<?php echo $admin['Phone']; ?>">
        <!-- Add avatar upload field -->
        <label for="Avatar">Avatar:</label>
        <input type="file" id="Avatar" name="Avatar">
        <?php if (!empty($admin['Avatar'])): ?>
            <img src="<?php echo $admin['Avatar']; ?>" alt="Avatar" style="max-width: 200px; margin-top: 10px; display: block;">
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
