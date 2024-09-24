<?php 

    $data = array(
        "Melody Run" => "mms_run.php", 
        "Concert" => "concert.php", 
        "Music Competition" => "musiccompetition.php", 
        "Music Lecture" => "musiclecture.php", 
        "Events" => "events.php",  
        "About Us" => "about_us.php",
        "Booking Details" => "userevent.php",
        "Feedback" => "feedback.php",
    );

    
    $results = array();
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $search_query = $_GET['search'];

        
        foreach($data as $item => $url) {
            if(stripos($item, $search_query) !== false) {
                $results[] = array('title' => $item, 'url' => $url);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/search.css">
</head>

<?php require 'headermember.php'; ?>


<body>
   
<div class="container">
       
<?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
    <?php if(!empty($results)): ?>
        <h2>Search Results:</h2>
        <ul>
            <?php foreach($results as $result): ?>
                <li><a href="<?php echo $result['url']; ?>"><?php echo $result['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
<?php endif; ?>

</div>
    
</body>
</html>
