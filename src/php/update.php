<?php
// Include the header
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


if (isset($_GET['events'])) {
    
    $eventIDs = explode(',', $_GET['events']);

    
    $sql = "SELECT * FROM event WHERE EventID IN (" . implode(',', $eventIDs) . ")";

    
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/update1.css">
            <title>Update Event</title>
        </head>

        <body>
            <div>
                <h1>Update Event</h1>
                <form method="post" action="">
                    <?php
                    while ($row = $result->fetch_object()) {
                    ?>
                        <table border="1" cellpadding="5" cellspacing="0">
                            <tr>
                                <th>Event ID</th>
                                <td><input type="hidden" name="event_id[]" value="<?= $row->EventID ?>"><?= $row->EventID ?></td>
                            </tr>
                            <tr>
                                <th>Event Name</th>
                                <td><input type="text" name="event_name[]" value="<?= $row->EventName ?>"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td><input type="date" name="event_date[]" value="<?= $row->EventDate ?>"></td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td><input type="text" name="event_location[]" value="<?= $row->EventLocation ?>"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td><input type="text" name="event_price[]" value="<?= $row->EventPrice ?>"></td>
                            </tr>
                            <tr>
                                <th>Capacity</th>
                                <td><input type="text" name="event_capacity[]" value="<?= $row->EventCapacity ?>"></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td><input type="text" name="event_time[]" value="<?= $row->EventTime ?>"></td>
                            </tr>
                            
                            <tr>
                                <th>Status</th>
                                <td><input type="text" name="event_status[]" value="<?= $row->status ?>"></td>
                            </tr>
                        </table>
                    <?php
                    }
                    ?>
                    <input type="submit" name="submit" value="Update Events">
                </form>
            </div>
        </body>

        </html>

        <?php
       
        if (isset($_POST['submit'])) {
           
            if (isset($_POST['event_name']) && isset($_POST['event_date']) && isset($_POST['event_location']) &&
                isset($_POST['event_price']) && isset($_POST['event_capacity']) && isset($_POST['event_time'])&& isset($_POST['event_status'])) {

               
                $stmt = $con->prepare("UPDATE event SET EventName=?, EventDate=?, EventLocation=?, EventPrice=?, EventCapacity=?, EventTime=?, status=? WHERE EventID=?");
$stmt->bind_param("ssssisss", $eventName, $eventDate, $eventLocation, $eventPrice, $eventCapacity, $eventTime, $eventStatus, $eventID);
               
                $eventNames = $_POST['event_name'];
                $eventDates = $_POST['event_date'];
                $eventLocations = $_POST['event_location'];
                $eventPrices = $_POST['event_price'];
                $eventCapacities = $_POST['event_capacity'];
                $eventTimes = $_POST['event_time'];
               
                $eventStatuses = $_POST['event_status'];
                $eventIDs = $_POST['event_id'];

             
                foreach ($eventIDs as $index => $eventID) {
                    $eventName = $eventNames[$index];
                    $eventDate = $eventDates[$index];
                    $eventLocation = $eventLocations[$index];
                    $eventPrice = $eventPrices[$index];
                    $eventCapacity = $eventCapacities[$index];
                    $eventTime = $eventTimes[$index];
                   
                    $eventStatus = $eventStatuses[$index];

                    
                    if (!$stmt->execute()) {
                        echo "Error updating record: " . $stmt->error;
                    }
                }

                echo "Events updated successfully.";

               
                echo '<meta http-equiv="refresh" content="2;url=admin_view.php">';
            } else {
                echo "Please provide event details.";
            }
        }
    } else {
        echo "No events found.";
    }
} else {
    echo "No events selected.";
}

$result->free();
$con->close();
?>
