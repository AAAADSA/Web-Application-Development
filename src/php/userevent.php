

    <?php
include 'headermember.php';
require_once 'helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$query = "SELECT t.status, t.ticketID, COALESCE(b.bookingID, 'Not booked') AS bookingID, 
                e.EventName, u.EventUserName, u.EventUserIC, u.EventEmail, u.EventPhone,
                b.bookingDate
          FROM ticket t 
          JOIN (
              SELECT EventID, MAX(EventDate) AS MaxDate 
              FROM event 
              GROUP BY EventID
          ) AS max_event ON t.EventID = max_event.EventID
          JOIN event e ON t.EventID = e.EventID AND e.EventDate = max_event.MaxDate
          JOIN user_event_details u ON t.EventID = u.EventID AND t.UserID = u.UserID
          LEFT JOIN booking b ON t.ticketID = b.ticketID
          WHERE t.UserID = ?
          GROUP BY t.ticketID"; 

$stmt = $con->prepare($query);

$stmt->bind_param("i", $user['UserID']); 

$stmt->execute();
$result = $stmt->get_result();

?>

<div class="profile-container">
    <h2>Your events</h2>
    <link rel="stylesheet" href="../css/userevent.css">
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<hr class='transparent-line'><br>";
        echo "<p><strong>Event Name:</strong> " . $row['EventName'] . "</p>";
        echo "<p><strong>Event User Name:</strong> " . $row['EventUserName'] . "</p>";
        echo "<p><strong>Event IC:</strong> " . $row['EventUserIC'] . "</p>";
        echo "<p><strong>Email:</strong> " . $row['EventEmail'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $row['EventPhone'] . "</p>";
        echo "<p><strong>Ticket Status:</strong> " . $row['status'] . "</p>";
        echo "<p><strong>Ticket ID:</strong> " . $row['ticketID'] . "</p>";
        echo "<p><strong>Booking ID:</strong> " . $row['bookingID'] . "</p>";
        echo "<p><strong>Booking Date:</strong> " . $row['bookingDate'] . "</p>";
        echo "<hr class='transparent-line'><br>";
        echo "</div>";
    }
    ?>
</div>

<?php require 'footer.php'; ?>
