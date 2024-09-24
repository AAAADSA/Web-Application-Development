<?php

$PAGE_TITLE = 'User Comments';

include('headeradmin.php');
require_once('helper.php');

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['admin'])) {
    header("Location:admin_login.php");
    exit();
}

$sql = "SELECT UserID, UserName, UserIC, UserEmail, UserComment, UserPhone FROM user WHERE UserComment IS NOT NULL";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_details.css">
    <title>User Comments</title>
</head>
<body>

    <div>
        <h1>User Comments</h1>

        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>User IC</th>
                <th>User Email</th>
                <th>User Phone</th>
                <th>User Comment</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    printf(
                        '<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                        </tr>',
                        $row['UserID'],
                        $row['UserName'],
                        $row['UserIC'],
                        $row['UserEmail'],
                        $row['UserPhone'],
                        $row['UserComment']
                    );
                }
                $result->free();
            } else {
                echo '<tr><td colspan="6">No user comments found</td></tr>';
            }
            ?>
        </table>
    </div>
    <?php
    $con->close();
    ?>
</body>
</html>
