<script>
function approveBooking(ticketId) {
    if (confirm("Are you sure you want to approve this booking?")) {
        
        $.ajax({
            url: 'approve_booking.php',
            type: 'POST',
            data: { ticket_id: ticketId },
            success: function(response) {
                // Handle success response
                alert("Booking approved successfully.");
               
            },
            error: function(xhr, status, error) {
          
                alert("Error approving booking: " + error);
            }
        });
    }
}
</script>
<?php

$ticket_id = $_POST['ticket_id'];


$sql = "UPDATE ticket SET status = 'Approved' WHERE ticketID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
   
    echo "success";
} else {
  
    echo "error";
}

?>
