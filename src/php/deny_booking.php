<?php

require_once 'helper.php';


$ticket_id = $_POST['ticket_id'];


$sql = "UPDATE ticket SET status = 'Denied' WHERE ticketID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
 
    echo "success";
} else {
   
    echo "error";
}


$stmt->close();
$con->close();
?>
