<!DOCTYPE html>
<html lang="en">
<head class="headDesign">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/header.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

    
</head>



<body>
    <nav>
    <div class="topic">
        <h4>
            <a href="homepage.php">Melody Maven Society 2024</a>
        </h4>
    </div>

    <div>
        <ul class="header" id="menuList">   
            <?php 
                echo "<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
                        <i class='fa fa-bars'></i>
                    </a>";

         
    echo "<li><a href='login.php' class='list'>Login</a></li>";  
    echo "<li><a href='admin_login.php' class='list'>Admin Login</a></li>";  

                
            ?>
    
            </li>
            
        </ul>   
    </div>
    </nav>
</body>

</html>