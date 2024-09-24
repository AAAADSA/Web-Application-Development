<?php
$PAGE_TITLE = 'Event Details';

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

$admin = $_SESSION['admin'];


$filter = isset($_GET['filter']) ? $_GET['filter'] : '';


$sql = "SELECT * FROM event";
if ($filter !== '') {
    $sql .= " WHERE EventName = '$filter'";
}

$result = $con->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_events.css">
    <title>Event Details</title>
</head>

<body>

    <div>
        <h1>List Event</h1>
       
        <table class="transparent-table">
           <tr>
    <td colspan="10" align="center">
        <form action="" method="GET">
            <label for="filter" style="color: white;">Filter by Events:</label>
            <select name="filter" id="filter">
                <option value="">All Events</option>
                <option value="MMS CONCERT" <?php if ($filter === "MMS CONCERT") echo "selected"; ?>>MMS CONCERT</option>
                <option value="Melody Maven Society Run (MMS)" <?php if ($filter === "Melody Maven Society Run (MMS)") echo "selected"; ?>>Melody Maven Society Run (MMS)</option>
                <option value="MMS Music Competition" <?php if ($filter === "MMS Music Competition") echo "selected"; ?>>MMS Music Competition</option>
                <option value="MMS Music Lecture" <?php if ($filter === "MMS Music Lecture") echo "selected"; ?>>MMS Music Lecture</option>
            </select>
            <input type="submit" value="Filter">
        </form>
    </td>
</tr>
        </table>
        
        <table class="transparent-table">
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Price</th>
                <th>Capacity</th>
                <th>Time</th>
               
                <th>Status</th>
                <th>Participants</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    
                    $participants_sql = "SELECT ud.EventUserName AS UserName
                     FROM user_event_details ud
                     WHERE ud.EventID = " . $row->EventID;

$participants_result = $con->query($participants_sql);

                    echo '<tr>';
                    echo '<td>' . $row->EventID . '</td>';
                    echo '<td>' . $row->EventName . '</td>';
                    echo '<td>' . $row->EventDate . '</td>';
                    echo '<td>' . $row->EventLocation . '</td>';
                    echo '<td>' . $row->EventPrice . '</td>';
                    echo '<td>' . $row->EventCapacity . '</td>';
                    echo '<td>' . $row->EventTime . '</td>';
                  
                    echo '<td>' . $row->status . '</td>'; 

                    echo '<td>';
                    if ($participants_result->num_rows > 0) {
                        while ($participant_row = $participants_result->fetch_object()) {
                            echo $participant_row->UserName . '<br>'; 
                        }
                    } else {
                        echo "No participants";
                    }
                    echo '</td>';

                    echo '</tr>';

                    
                    $participants_result->free();
                }

                echo '<tr>';
                echo '<td colspan="10">'; 
                printf('
                    %d record(s) returned.
                    [ <a href="admin_edit.php" class="btn-add">Delete Event</a> ] 
                    [ <a href="admin_update.php" class="btn-add">Update Event</a> ]',
                    $result->num_rows);
                echo '</td>';
                echo '</tr>';

                $result->free();
                $con->close();
            } else {
            ?>
                <tr>
                    <td colspan="10">No record found</td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

</body>

</html>