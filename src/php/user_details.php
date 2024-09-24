<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_details.css">
    <title>User Details</title>
</head>
<body>
  
<?php 

include 'headeradmin.php';
require_once 'helper.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$PAGE_TITLE = 'User details';


$admin = $_SESSION['admin'];


$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$filter_condition = '';
if ($filter !== 'All' && preg_match('/^[a-zA-Z]$/', $filter)) {
    $filter_condition = " WHERE UserName LIKE '$filter%'";
}


$sql = "SELECT UserID, UserName, UserIC, UserPhone, UserEmail
        FROM user
        $filter_condition
        ORDER BY UserName ASC"; 

$result = $con->query($sql);

?>

<div>
    <h1>List User</h1>
    
    
    <table border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td align="right" colspan="6">
                <form action="" method="GET">
                    <label for="filter" style="color: white;">Filter by Alphabet:</label>
                    <select name="filter" id="filter">
                        <option value="All">All</option>
                        <?php
                       
                        for ($i = 65; $i <= 90; $i++) {
                            $char = chr($i);
                            echo "<option value='$char'>$char</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Filter">
                </form>
            </td>
        </tr>
    </table>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <th>User Name</th>
            <th>User IC</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Details</th> 
        </tr>

        <?php
        
        if ($result->num_rows > 0) {
          
            while ($row = $result->fetch_object()) {
                printf('
                    <tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td><a href="user_details2.php?id=%s" class="btn-details">Details</a></td>
                    </tr>',
                    $row->UserName,
                    $row->UserIC,
                    $row->UserPhone,
                    $row->UserEmail,
                    $row->UserID
                );
            }
            
            printf('
                <tr>
                    <td colspan="5">
                        %d record(s) returned.
                        [ <a href="user_delete.php" class="btn-add">Delete User(s)</a> ] 
                        [ <a href="user_comment.php" class="btn-add">View Comment(s)</a> ] 
                    </td>
                </tr>',
                $result->num_rows
            );

            // Free the result set
            $result->free();
        } else {
           
            echo '<tr><td colspan="5">No record found</td></tr>';
        }

        
        $con->close();
        ?>
    </table>
</div>

</body>
</html>
