<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_details2.css">
    <title>User Details</title>
</head>
<body>
<?php 
    include 'headeradmin.php';
    require_once 'helper.php';
    $PAGE_TITLE = 'User details';
    
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    if (!isset($_SESSION['admin'])) {
        header("Location: admin_login.php");
        exit();
    }
    
    $admin = $_SESSION['admin'];

    
    if (isset($_GET['id'])) {
        $userID = $_GET['id']; 

    
        $query_user = "SELECT * FROM user WHERE UserID = ?";
        $stmt_user = $con->prepare($query_user);
        $stmt_user->bind_param("i", $userID);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
?>
            <div class="profile-container">
                <h2>User Details</h2>
                <ul>
                    <li><strong>User ID:</strong> <?php echo $user['UserID']; ?></li>
                    <li><strong>User Name:</strong> <?php echo $user['UserName']; ?></li>
                    <li><strong>User IC:</strong> <?php echo $user['UserIC']; ?></li>
                    <li><strong>User Phone:</strong> <?php echo $user['UserPhone']; ?></li>
                    <li><strong>User Email:</strong> <?php echo $user['UserEmail']; ?></li>
                </ul>
                <h2>Event Participation</h2>
                <table border="1" cellpadding="5" cellspacing="0">
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Event Location</th>
                        <th>Event User Name</th>
                        <th>Event User IC</th>
                        <th>Event Email</th>
                        <th>Event Phone</th>
                        <th>Ticket Status</th>
                        <th>Booking ID</th>
                        <th>Ticket ID</th>
                    </tr>
                    <?php
                       
                        $query_event = "SELECT  
                            t.status, 
                            t.ticketID, 
                            COALESCE(b.bookingID, 'Not booked') AS bookingID, 
                            e.EventName, 
                            e.EventDate,
                            e.EventLocation,
                            u.EventUserName, 
                            u.EventUserIC, 
                            u.EventEmail, 
                            u.EventPhone
                        FROM 
                            ticket t 
                        JOIN (
                            SELECT 
                                EventID, 
                                MAX(EventDate) AS MaxDate 
                            FROM 
                                event 
                            GROUP BY 
                                EventID
                        ) AS max_event ON t.EventID = max_event.EventID
                        JOIN 
                            event e ON t.EventID = e.EventID AND e.EventDate = max_event.MaxDate
                        JOIN 
                            user_event_details u ON t.EventID = u.EventID AND t.UserID = u.UserID
                        LEFT JOIN 
                            booking b ON t.ticketID = b.ticketID
                        WHERE 
                            u.UserID = ? AND t.UserID = ?
                        GROUP BY 
                            t.ticketID";
                        $stmt_event = $con->prepare($query_event);
                        $stmt_event->bind_param("ii", $userID, $userID); 
                        $stmt_event->execute();
                        $result_event = $stmt_event->get_result();

                        while ($row = $result_event->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['EventName']}</td>";
                            echo "<td>{$row['EventDate']}</td>";
                            echo "<td>{$row['EventLocation']}</td>";
                            echo "<td>{$row['EventUserName']}</td>";
                            echo "<td>{$row['EventUserIC']}</td>";
                            echo "<td>{$row['EventEmail']}</td>";
                            echo "<td>{$row['EventPhone']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>{$row['bookingID']}</td>";
                            echo "<td>{$row['ticketID']}</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
<?php
        } else {
            echo "<p>No user details found.</p>";
        }
    } else {
        echo "<p>User ID not provided.</p>";
    }

   
    $con->close();
?>

    <div class="profile-container">
        <button onclick="window.location.href = 'user_details.php';">Back to List Users</button>
    </div>
</body>
</html>