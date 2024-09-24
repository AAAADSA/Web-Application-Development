<!DOCTYPE html>
<html lang="en">
<head class="headDesign">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/admin_header.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

    
</head>

    

<body>
    <nav>
    <div class="topic">
        <h4>
            <a href="index.php">Melody Maven Society 2024</a>
        </h4>
    </div>

    <div>
        <ul class="header" id="menuList">   
            <?php 
           
                echo "<li><a href = 'admin_add.php' class='list'>Add Events</a></li>";
                echo "<li><a href = 'admin_view.php' class='list'>View Events</a></li>";
                echo "<li><a href = 'admin_update.php' class='list'>Update Events</a></li>";
                 echo "<li><a href = 'user_details.php' class='list'>User Details</a></li>";
                echo "<a href='javascript:void(0);' class='icon' onclick='myFunction()'>
                        <i class='fa fa-bars'></i>
                    </a>";
            
            
           
    echo "<li><a href='http://localhost/WEB/php/login.php' class='list'>Login</a></li>";
    echo "<li><a href='http://localhost/WEB/php/admin_login.php' class='list'>Admin</a></li>";   


                
            ?>
            <li class="search-container">
                 <form action="admin_search.php" method="GET">
        <input type="text" name="search" placeholder="Search...">
       
        
    </form>
            </li>
            
        </ul>   
    </div>
    </nav>
</body>
</html>