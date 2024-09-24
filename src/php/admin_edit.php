<?php

include('headeradmin.php');
require_once 'helper.php';

    if (!isset($_SESSION['admin'])) {
        header("Location:admin_login.php");
        exit();
    }
    

    $admin = $_SESSION['admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['delete_event'])) {
        
        $eventIDs = implode(',', $_POST['delete_event']);
        header("Location: delete.php?events=$eventIDs");
        exit();
    }
}

require_once('helper.php');

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "SELECT * FROM event";
$result = $con->query($sql);


    $PAGE_TITLE = 'Add Event';
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_edit.css">
    <title>Edit Event</title>
</head>
<body>
    <div>
        <h1>List Event</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>Select</th>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Capacity</th>
                    <th>Time</th>
                </tr>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_object()) {
                            printf('
                                <tr>
                                    <td><input type="checkbox" name="delete_event[]" value="%s"></td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                </tr>',
                            $row->EventID,
                            $row->EventID,
                            $row->EventName,
                            $row->EventDate,
                            $row->EventLocation,
                            $row->EventPrice,
                            $row->EventCapacity,
                            $row->EventTime
                            );
                        }
                        $result->free();
                    } else {
                        echo '<tr><td colspan="8">No events found</td></tr>';
                    }
                ?>
            </table>
            <input type="submit" value="Delete Selected Events">
        </form>
    </div>
</body>
</html>
