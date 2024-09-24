<?php 
require_once 'helper.php';
include 'headermember.php';


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if(isset($_SESSION['ticketID'])) {
    $ticket_id = $_SESSION['ticketID'];
} else {
 
    header("Location: homeplogout.php");
    exit();
}


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$err = '';
$success_msg = '';


if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

   
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        
        if (!in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) {
            $err = 'Only JPG, GIF, and PNG formats are allowed.';
        } else {
            $upload_dir = 'uploads/';
            $save_as = uniqid() . '.' . $ext;

            
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $save_as)) {
               
                $sql_update_image_url = "UPDATE ticket SET image_url = ? WHERE ticketID = ?";
                $stmt_update_image_url = $con->prepare($sql_update_image_url);
                $stmt_update_image_url->bind_param("si", $image_url, $ticket_id);
                $image_url = $upload_dir . $save_as;
                if ($stmt_update_image_url->execute()) {
                  
                    $success_msg = 'Image uploaded successfully. It is saved as ' . $save_as . '.';
                } else {
                    $err = 'Failed to update image URL in ticket table.';
                }
            } else {
                $err = 'Failed to move uploaded file.';
            }
        }
    } else {
        switch ($file['error']) {
            case UPLOAD_ERR_NO_FILE:
                $err = 'No file was selected.';
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $err = 'File uploaded is too large. Maximum 1MB allowed.';
                break;
            default:
                $err = 'There was an error while uploading the file.';
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link rel="stylesheet" href="../css/upload1.css">
</head>
<body>
    <div class="container">
        <h1>Upload Image</h1>
        <?php if ($success_msg): ?>
            <div class="success"><?php echo $success_msg; ?></div>
           
            <a href="completepayment.php" class="btn">Complete Booking</a>
        <?php elseif ($err): ?>
            <div class="error"><?php echo $err; ?></div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data" class="upload-form">
            <label for="file" class="file-label">Choose an image to upload:</label>
            <input type="file" name="file" id="file" class="file-input" />
            <input type="submit" name="submit" value="Upload" class="upload-btn" />
        </form>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>
