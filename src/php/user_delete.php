<?php

$PAGE_TITLE = 'Delete User';

include('headeradmin.php');
require_once('helper.php');


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    if (!isset($_SESSION['admin'])) {
        header("Location:admin_login.php");
        exit();
    }
    

    $admin = $_SESSION['admin'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete_user'])) {
        
        foreach($_POST['delete_user'] as $userName) {
            $sql = "DELETE FROM user WHERE UserName='$userName'";
            if ($con->query($sql) === TRUE) {
                echo '<span style="color: green;">' . $userName . ' deleted successfully.</span><br>';
            } else {
                echo '<span style="color: red;">Error deleting ' . $userName . ': ' . $con->error . '</span><br>';
            }
            
        }
    }
}


$sql = "SELECT * FROM user";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/user_delete.css">
    <title>Delete User</title>
</head>
<body>
  
<div>
    <h1>List Users</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"onsubmit="return confirmDelete()">
      
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>User Name</th>
                <th>User IC</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    printf('
                        <tr>
                            <td><input type="checkbox" name="delete_user[]" value="%s"></td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                          
                        </tr>',
                    $row->UserName,
                    $row->UserName,
                    $row->UserIC,
                    $row->UserPhone,
                    $row->UserEmail,                
                  
                    );
                }
                $result->free();
            } else {
                echo '<tr><td colspan="7">No user(s) found</td></tr>';
            }
        ?>
        </table>
        <input type="submit" value="Delete Selected User(s)" class="delete-button">


    </form>
</div>
    
    <script>
    function confirmDelete() {
        
        var selectedUsers = document.querySelectorAll('input[name="delete_user[]"]:checked');
        if (selectedUsers.length === 0) {
            alert("Please select at least one user.");
            return false; 
        }
        return confirm("Are you sure you want to delete the selected users?");
    }
</script>
<?php

$con->close();
?>

</body>
</html>

