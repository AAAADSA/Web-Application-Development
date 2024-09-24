<?php
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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event'])) {
    
    foreach ($_POST['delete_event'] as $delete_event_id) {
        
        $stmt = $con->prepare("DELETE FROM event WHERE EventID = ?");
        $stmt->bind_param("i", $delete_event_id); 
        $stmt->execute();
        $stmt->close();
    }
    // JavaScript alert after successful deletion
    echo "<script>alert('Events successfully deleted'); window.location='admin_view.php';</script>";
    exit(); 
}

$eventIDs = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['events'])) {
    $eventIDs = explode(',', $_GET['events']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/delete.css">
    <title>Delete Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            vertical-align: top; 
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        input[type="submit"], a.button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover, a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Events</h1>
        <p>Are you sure you want to delete the following events?</p>
        <form method="post" action="">
            <table>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Capacity</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($eventIDs as $eventID) {
                    $sql = "SELECT * FROM event WHERE EventID=$eventID";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['EventID'] . "</td>";
                            echo "<td>" . $row['EventName'] . "</td>";
                            echo "<td>" . $row['EventDate'] . "</td>";
                            echo "<td>" . $row['EventLocation'] . "</td>";
                            echo "<td>" . $row['EventPrice'] . "</td>";
                            echo "<td>" . $row['EventCapacity'] . "</td>";
                            echo "<td>" . $row['EventTime'] . "</td>";
                            echo "<td><input type='checkbox' name='delete_event[]' value='" . $row['EventID'] . "' checked></td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>
            </table>
            <input type="submit" value="Delete">
            <a href="admin_view.php" class="button">Cancel</a>
        </form>
    </div>
</body>
</html>
