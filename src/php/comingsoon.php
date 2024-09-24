<?php
require_once 'helper.php';
include 'headermember.php';


if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$currentDate = date('Y-m-d');
$sql = "SELECT EventID, EventName, EventDate, EventLocation
        FROM event
        WHERE EventDate > ? AND status = 'COMMING SOON'";


$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Error in preparing statement: " . $con->error);
}

$stmt->bind_param("s", $currentDate); 
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/comingsoon.css">
    <title>Coming Soon Events</title>
</head>

<body>

    <header>
     
    </header>

    <div class="event">
        <h2>Coming Soon Events</h2>
        <table>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Location</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['EventName']}</td>";
                    echo "<td>{$row['EventDate']}</td>";
                    echo "<td>{$row['EventLocation']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No coming soon events</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php require 'footer.php'; ?>

</body>
</html>
