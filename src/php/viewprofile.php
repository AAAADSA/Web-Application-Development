<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333333; 
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .profile-details {
            text-align: center;
        }

        .avatar {
            margin-bottom: 20px;
        }

        .avatar img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #fff; 
            cursor: pointer; 
            transition: transform 0.3s; 
        }

        
        .avatar img:hover {
            transform: scale(1.1);
        }

        .profile-details p {
            font-size: 16px;
            margin: 5px 0;
        }

        .transparent-line {
            border: none;
            height: 1px;
            background-color: #ccc;
        }

        .edit-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .edit-link:hover {
            background-color: #0056b3;
        }

        .lightbox {
            display: none;
            position: fixed;
            z-index: 9999;
            width: 50%;
            height: 50%;
            top: 25%; 
            left: 25%; 
            background-color: rgba(0, 0, 0, 0.8);
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

       
        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            margin-top: 5%;
            border-radius: 10px;
        }

       
        .lightbox span {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
<body>
<?php 

include 'headermember.php';

require_once 'helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = mysqli_real_escape_string($con, $_POST['username']);
   
    
    $query = "UPDATE users SET UserName='$username' WHERE UserID=" . $user['UserID'];
    if ($con->query($query) === TRUE) {
        $_SESSION['user']['UserName'] = $username;
        header("Location: viewprofile.php");
        exit();
    } else {
        echo "Error updating profile: " . $con->error;
    }
}
?>


<div class="profile-container">
    <h2>User Profile</h2>
    <div class="profile-details">
      
       <div class="avatar" onclick="showLightbox('<?php echo $user['Avatar']; ?>')">
    <?php if (!empty($user['Avatar'])): ?>
        <img src="<?php echo $user['Avatar']; ?>" alt="Avatar">
    <?php else: ?>
        <img src="../images/default_avatar.jpg" alt="Default Avatar">
    <?php endif; ?>
</div>
       
        <p><strong>Username:</strong> <?php echo $user['UserName']; ?></p>
        <br>
        <hr class='transparent-line'>
        <br>
        <p><strong>UserIC:</strong> <?php echo $user['UserIC']; ?></p>
        <br>
        <hr class='transparent-line'>
        <br>
        <p><strong>Email:</strong> <?php echo $user['UserEmail']; ?></p>
        <br>
        <hr class='transparent-line'>
        <br>
        <p><strong>Phone:</strong> <?php echo $user['UserPhone']; ?></p>
        <br>
        <a href="editprofile.php" class="edit-link">Edit Profile</a>
    </div>
</div>


<div class="lightbox" id="lightbox">
    <span onclick="hideLightbox()">&times;</span>
    <img id="lightbox-image" src="" alt="Large Avatar">
</div>


<script>
    
    function showLightbox(imageUrl) {
        document.getElementById("lightbox").style.display = "block";
        document.getElementById("lightbox-image").src = imageUrl;
    }

  
    function hideLightbox() {
        document.getElementById("lightbox").style.display = "none";
    }
</script>

</body>
</html>
