<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: whitesmoke;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 600px;
            margin: 200px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px black;
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
        
        .edit-link:hover {
    background-color: yellowgreen;
    transition: background-color 0.3s;
}
    </style>
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
?>


<div class="profile-container">
    <h2>Admin Profile</h2>
    <div class="profile-details">
       
        <div class="avatar" onclick="showLightbox('<?php echo $admin['Avatar']; ?>')">
            <?php if (!empty($admin['Avatar'])): ?>
                <img src="<?php echo $admin['Avatar']; ?>" alt="Avatar">
            <?php else: ?>
                <img src="../images/default_avatar.jpg" alt="Default Avatar">
            <?php endif; ?>
        </div>
     
        <p><strong>Name:</strong> <?php echo $admin['AdminName']; ?></p>
        <p><strong>ID:</strong> <?php echo $admin['AdminID']; ?></p>
        <p><strong>Email:</strong> <?php echo $admin['Email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $admin['Phone']; ?></p>
        <br>
      
        <a href="admin_editprofile.php" class="edit-link">Edit Profile</a>
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