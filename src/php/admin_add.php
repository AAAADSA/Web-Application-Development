<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_add.css">
    <title>Add Event</title>
</head>
<body>
<?php include 'headeradmin.php';
 require_once 'helper.php';
    $PAGE_TITLE = 'Add Event';
    
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    if (!isset($_SESSION['admin'])) {
        header("Location:admin_login.php");
        exit();
    }
    

    $admin = $_SESSION['admin'];
 ?>  
    
<?php
$sql = 'SELECT MAX(EventID) AS max_id FROM event';
$result = $con->query($sql);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];


$EventID = $max_id + 1;

if (!empty($_POST)) 
{
    $EventName    = strtoupper(trim($_POST['EventName']));
    $EventDate  =  trim($_POST['EventDate']);
    $EventLocation = trim($_POST['EventLocation']);
    $EventPrice = $_POST['EventPrice'];
    if ($EventPrice == "Other") {
        $EventPrice = trim($_POST['CustomPrice']);
    }
    $EventCapacity  =  trim($_POST['EventCapacity']);
    $StartTime = $_POST['StartTime'];
    $EndTime = $_POST['EndTime'];

    
    $EventTime = $StartTime . ' - ' . $EndTime;
    
 
    if (empty($error)) 
    {
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $sql = '
        INSERT INTO event (EventID, EventName,EventDate, EventLocation, EventPrice,EventCapacity,EventTime,status)
        VALUES (?, ?, ?, ?,?,?,?,?)
        ';
        
        $status = "COMMING SOON"; 

$stm = $con->prepare($sql);

$stm->bind_param('ssssssss', $EventID, $EventName, $EventDate, $EventLocation, $EventPrice, $EventCapacity, $EventTime, $status);

        $stm->execute();
        
        if ($stm->affected_rows > 0) 
        {
            printf('
            <div class="info">
            Event <strong>%s</strong> has been inserted.
            [ <a href="admin_view.php">Back to list</a> ]
            </div>',
            $EventName);

            // Reset fields.
    
            $EventID = rand(10, 100); 
            $EventName = $EventDate = $EventLocation = $EventPrice = $EventCapacity = $EventTime = null;
        }
        else 
        {
            echo '
            <div class="error">
            Opps. Database issue. Record not added.
            </div>
            ';
        }
        
        $stm->close();
        $con->close();
    }
    else 
    {
        echo '<ul class="error">';
        foreach ($error as $value)
        {
            echo "<li>".$value."</li>";
        }
        echo '</ul>';
    }
}
?>

    
    
<script>
    function validateForm() {
        var eventName = document.forms["myForm"]["EventName"].value;
        var eventDate = document.forms["myForm"]["EventDate"].value;
        var eventLocation = document.forms["myForm"]["EventLocation"].value;
        var eventPrice = document.forms["myForm"]["EventPrice"].value;
        var eventCapacity = document.forms["myForm"]["EventCapacity"].value;
        var startTime = document.forms["myForm"]["StartTime"].value;
        var endTime = document.forms["myForm"]["EndTime"].value;

        if (eventName == "" || eventDate == "" || eventLocation == "" || eventPrice == "" || eventCapacity == "" || startTime == "" || endTime == "") {
            alert("Please fill in all required fields: Event Name, Date, Location, Price, Capacity, Start Time, and End Time");
            return false;
        }

        if (eventPrice == "Other" && isNaN(document.forms["myForm"]["CustomPrice"].value)) {
            alert("Please enter a valid price.");
            return false;
        }
    }
</script>



<form name="myForm" action="" method="post" onsubmit="return validateForm()">
    <table cellpadding="5" cellspacing="0">
        <tr>
            <td><label for="EventID">Event ID :</label></td>
            <td><?php echo $EventID; ?></td>
        </tr>
        <tr>
            <td><label for="EventName">Event Name :</label></td>
            <td>
            <input type="text" id="EventName" name="EventName" value="<?php echo isset($EventName) ? htmlspecialchars($EventName) : ''; ?>" maxlength="30" required>

            </td>
        </tr>
       <tr>
    <td><label for="EventDate">Date :</label></td>
    <td>
        <input type="date" id="EventDate" name="EventDate" value="<?php echo isset($EventDate) ? $EventDate : ''; ?>" required>
    </td>
</tr>        <tr>
            <td><label for="EventLocation">Location :</label></td>
            <td>
                <input type="text" id="EventLocation" name="EventLocation" value="<?php echo isset($EventLocation) ? htmlspecialchars($EventLocation) : ''; ?>" maxlength="30" required>

            </td>
        </tr>
        <tr>
            <td><label for="EventPrice">Price :</label></td>
            <td>
               <input type="text" id="EventPrice" name="EventPrice" value="<?php echo isset($EventPrice) ? htmlspecialchars($EventPrice) : ''; ?>" maxlength="30" required>

            </td>
        </tr>
        <tr>
            <td><label for="EventCapacity">Capacity :</label></td>
            <td>
               <input type="text" id="EventCapacity" name="EventCapacity" value="<?php echo isset($EventCapacity) ? htmlspecialchars($EventCapacity) : ''; ?>" maxlength="30" required>

            </td>
        </tr>
       <tr>
    <td><label for="StartTime">Start Time :</label></td>
    <td>
        <select id="StartTime" name="StartTime">
            <option value="08:00 AM">8:00 AM</option>
            <option value="08:15 AM">8:15 AM</option>
            <option value="08:30 AM">8:30 AM</option>
            <option value="08:45 AM">8:45 AM</option>
            <option value="09:00 AM">9:00 AM</option>
            <option value="09:15 AM">9:15 AM</option>
            <option value="09:30 AM">9:30 AM</option>
            <option value="09:45 AM">9:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">1:00 PM</option>
            <option value="01:15 PM">1:15 PM</option>
            <option value="01:30 PM">1:30 PM</option>
            <option value="01:45 PM">1:45 PM</option>
            <option value="02:00 PM">2:00 PM</option>
            <option value="02:15 PM">2:15 PM</option>
            <option value="02:30 PM">2:30 PM</option>
            <option value="02:45 PM">2:45 PM</option>
            <option value="03:00 PM">3:00 PM</option>
            <option value="03:15 PM">3:15 PM</option>
            <option value="03:30 PM">3:30 PM</option>
            <option value="03:45 PM">3:45 PM</option>
            <option value="04:00 PM">4:00 PM</option>
            <option value="04:15 PM">4:15 PM</option>
            <option value="04:30 PM">4:30 PM</option>
            <option value="04:45 PM">4:45 PM</option>
            <option value="05:00 PM">5:00 PM</option>
            <option value="05:15 PM">5:15 PM</option>
            <option value="05:30 PM">5:30 PM</option>
            <option value="05:45 PM">5:45 PM</option>
            <option value="06:00 PM">6:00 PM</option>
            <option value="06:15 PM">6:15 PM</option>
            <option value="06:30 PM">6:30 PM</option>
            <option value="06:45 PM">6:45 PM</option>
            <option value="07:00 PM">7:00 PM</option>
            <option value="07:15 PM">7:15 PM</option>
            <option value="07:30 PM">7:30 PM</option>
            <option value="07:45 PM">7:45 PM</option>
            <option value="08:00 PM">8:00 PM</option>
            <option value="08:15 PM">8:15 PM</option>
            <option value="08:30 PM">8:30 PM</option>
            <option value="08:45 PM">8:45 PM</option>
            <option value="09:00 PM">9:00 PM</option>
            <option value="09:15 PM">9:15 PM</option>
            <option value="09:30 PM">9:30 PM</option>
            <option value="09:45 PM">9:45 PM</option>
        </select>
    </td>
</tr>
<tr>
    <td><label for="EndTime">End Time :</label></td>
    <td>
        <select id="EndTime" name="EndTime">
            <option value="08:00 AM">8:00 AM</option>
            <option value="08:15 AM">8:15 AM</option>
            <option value="08:30 AM">8:30 AM</option>
            <option value="08:45 AM">8:45 AM</option>
            <option value="09:00 AM">9:00 AM</option>
            <option value="09:15 AM">9:15 AM</option>
            <option value="09:30 AM">9:30 AM</option>
            <option value="09:45 AM">9:45 AM</option>
            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>
            <option value="01:00 PM">1:00 PM</option>
            <option value="01:15 PM">1:15 PM</option>
            <option value="01:30 PM">1:30 PM</option>
            <option value="01:45 PM">1:45 PM</option>
            <option value="02:00 PM">2:00 PM</option>
            <option value="02:15 PM">2:15 PM</option>
            <option value="02:30 PM">2:30 PM</option>
            <option value="02:45 PM">2:45 PM</option>
            <option value="03:00 PM">3:00 PM</option>
            <option value="03:15 PM">3:15 PM</option>
            <option value="03:30 PM">3:30 PM</option>
            <option value="03:45 PM">3:45 PM</option>
            <option value="04:00 PM">4:00 PM</option>
            <option value="04:15 PM">4:15 PM</option>
            <option value="04:30 PM">4:30 PM</option>
            <option value="04:45 PM">4:45 PM</option>
            <option value="05:00 PM">5:00 PM</option>
            <option value="05:15 PM">5:15 PM</option>
            <option value="05:30 PM">5:30 PM</option>
            <option value="05:45 PM">5:45 PM</option>
            <option value="06:00 PM">6:00 PM</option>
            <option value="06:15 PM">6:15 PM</option>
            <option value="06:30 PM">6:30 PM</option>
            <option value="06:45 PM">6:45 PM</option>
            <option value="07:00 PM">7:00 PM</option>
            <option value="07:15 PM">7:15 PM</option>
            <option value="07:30 PM">7:30 PM</option>
            <option value="07:45 PM">7:45 PM</option>
            <option value="08:00 PM">8:00 PM</option>
            <option value="08:15 PM">8:15 PM</option>
            <option value="08:30 PM">8:30 PM</option>
            <option value="08:45 PM">8:45 PM</option>
            <option value="09:00 PM">9:00 PM</option>
            <option value="09:15 PM">9:15 PM</option>
            <option value="09:30 PM">9:30 PM</option>
            <option value="09:45 PM">9:45 PM</option>
        </select>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <button type="submit" name="Add">Add</button>
        <button type="button" onclick="location='admin_view.php'">Cancel</button>
    </td>
</tr>

    </table>

   
</form>