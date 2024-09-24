<?php 
require_once 'helper.php';
include 'headeradmin.php'; 

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php"); 
    exit();
}


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$success_msg = '';


if (isset($_POST['approve']) || isset($_POST['deny'])) {
    $ticket_id = $_POST['ticket_id'];
    $action = isset($_POST['approve']) ? "approved" : "denied";

   
    $ticket_status = isset($_POST['approve']) ? "Booked" : "Canceled";
    $sql_update_ticket_status = "UPDATE ticket SET status = ? WHERE ticketID = ?";
    $stmt_update_ticket_status = $con->prepare($sql_update_ticket_status);
    $stmt_update_ticket_status->bind_param("si", $ticket_status, $ticket_id);

    if ($stmt_update_ticket_status->execute()) {
        $success_msg = "Ticket $action successfully.";
    } else {
        $err = "Failed to update ticket status.";
    }
}


$sql_pending_tickets = "SELECT * FROM ticket WHERE image_url IS NOT NULL AND status = 'Pending'";
$result_pending_tickets = $con->query($sql_pending_tickets);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval</title>
    <link rel="stylesheet" href="../css/managebooking.css">

</head>
<body>
    <div class="container">
        <h1>Admin Approval</h1>
        <?php if ($success_msg): ?>
            <div class="success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        <?php if ($result_pending_tickets->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Ticket ID</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result_pending_tickets->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['ticketID']; ?></td>
                        <td>
                            <!-- Added onclick event to open modal -->
                            <img src="<?php echo $row['image_url']; ?>" alt="Ticket Image" width="100" onclick="openModal('<?php echo $row['image_url']; ?>')">
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="ticket_id" value="<?php echo $row['ticketID']; ?>">
                                <input type="submit" name="approve" value="Approve">
                                <input type="submit" name="deny" value="Deny">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No pending tickets for approval.</p>
        <?php endif; ?>
    </div>

   

   
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <script>

        function openModal(imgUrl) {
            var modal = document.getElementById('myModal');
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = imgUrl;
        }

      
        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        }
    </script>
</body>
</html>