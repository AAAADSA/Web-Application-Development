<?php 
include 'headermember.php';
require_once 'helper.php';

$PAGE_TITLE = 'MMS Music Competition';
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];


$event_id = 1; 

// 获取活动信息
$sql_event = "SELECT * FROM event WHERE EventID = ?";
$stmt_event = $con->prepare($sql_event);
$stmt_event->bind_param("i", $event_id);
$stmt_event->execute();
$result_event = $stmt_event->get_result();
$event = $result_event->fetch_assoc();
$stmt_event->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
   
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $id_card = $_POST['id_card'];
    
   
    $sql_create_ticket = "INSERT INTO ticket (EventID, UserID, status) VALUES (?, ?, 'Pending')";
    $stmt_create_ticket = $con->prepare($sql_create_ticket);
    $stmt_create_ticket->bind_param("ii", $event_id, $user['UserID']);
    $stmt_create_ticket->execute();
    

    $ticket_id = $stmt_create_ticket->insert_id;
    
    
    $stmt_create_ticket->close();
    
  
    $sql_insert_registration = "INSERT INTO user_event_details (UserID, EventID, EventEmail, EventUserName, EventPhone, EventUserIC, ticketID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_registration = $con->prepare($sql_insert_registration);
    $stmt_insert_registration->bind_param("iissssi", $user['UserID'], $event_id, $email, $name, $phone, $id_card, $ticket_id);
    
    if ($stmt_insert_registration->execute()) {
       
        $booking_date = date("Y-m-d");
        $sql_create_booking = "INSERT INTO booking (ticketID, bookingDate) VALUES (?, ?)";
        $stmt_create_booking = $con->prepare($sql_create_booking);
        $stmt_create_booking->bind_param("is", $ticket_id, $booking_date);
        $stmt_create_booking->execute();
        $stmt_create_booking->close();

  
        $_SESSION['ticketID'] = $ticket_id;
        
        header("Location: payment.php");
        exit();
    } else {
        echo "Error: " . $sql_insert_registration . "<br>" . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/eventregister1.css">
    <title>MMS Concert</title>
</head>
<body>
    <div class="container">
        <div class="eventh2">
            <h2><?php echo $event['EventName']; ?></h2>
        </div>
        <div class="gaminge1">
            <img src="../image/concert.jpeg" alt="<?php echo $event['EventName']; ?>">
        </div>
       
        <div class="event">
            <p>
                <ul>
                    <li>Welcome to our Concert Extravaganza!</li>
                    <li>Get ready to immerse yourself in a world of rhythm, melody, and unforgettable performances</li>
                    <li>Book your tickets today and let the music sweep you off your feet!</li>
                </ul>      
            </p>
        </div>
        <div class="event-details">
            <div class="details">
                <p><strong>Event Name:</strong> <?php echo $event['EventName']; ?></p>
                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['EventDate'])); ?></p>
                <p><strong>Time:</strong> <?php echo $event['EventTime']; ?></p>
                <p><strong>Location:</strong> <?php echo $event['EventLocation']; ?></p>
                <p><strong>Price:</strong> <?php echo $event['EventPrice']; ?></p>
                <p><strong>Capacity:</strong> <?php echo $event['EventCapacity']; ?></p>
            </div>
            <div class="user-input">
                <form id="registrationForm" action="" method="post">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div>
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div>
                        <label for="id_card">ID Card:</label>
                        <input type="text" id="id_card" name="id_card" required>
                    </div>
                 
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    <input type="submit" name="register" class="buy-1" value="Register">
                </form>
            </div>
        </div>
    </div>
    <hr>
    
    <?php require 'footer.php'; ?>
</body>
</html>
