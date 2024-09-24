<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../css/payment.css">
</head>
<body>
    <?php include 'headermember.php';
 require_once 'helper.php';
    
    $PAGE_TITLE = 'About Us';
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
    if($con->connect_error){
        die("Connection failed: " . $con->connect_error);
    }

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
    

    $user = $_SESSION['user'];
?>
    <div class="container">
        <div class="payment-methods">
            <div class="payment-options">
                <div class="payment-option">
                    <label>
                        <input type="radio" name="payment_method" value="tng">
                        TNG Payment
                    </label>
                </div>
                <div class="payment-option">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card">
                        Credit Card
                    </label>
                </div>
                <div class="payment-option">
                    <label>
                        <input type="radio" name="payment_method" value="paypal">
                        PayPal
                    </label>
                </div>
            </div>
            <div class="payment-details">
                <div id="creditCardDetails" style="display: none;">
                    <h3>Enter Credit Card Details</h3>
                    <form id="creditCardForm">
                        <label for="cardNumber">Card Number:</label>
                        <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 1234 1234 1234" required><br><br>
                        <label for="expiryDate">Expiry Date:</label>
                        <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required><br><br>
                        <label for="cvv">CVV:</label>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" required><br><br>
                    </form>
                </div>
                <div id="paymentImage" style="display: none;">
                    <img src="../image/tng.jpg" alt="TNG Payment Image">
                </div>
                <div id="paypalLogin" style="display: none;">
                    <h3>Log in to PayPal</h3>
                    <form id="paypalLoginForm">
                        <label for="paypalEmail">Email:</label>
                        <input type="email" id="paypalEmail" name="paypalEmail" placeholder="Enter your email" required><br><br>
                        <label for="paypalPassword">Password:</label>
                        <input type="password" id="paypalPassword" name="paypalPassword" placeholder="Enter your password" required><br><br>
                      
                    </form>
                </div>
            </div>
        </div>
        <a href="upload.php" class="button">
    <button id="payButton">Proceed to Pay</button>
</a>

       
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('creditCardDetails');
        const paymentImageDiv = document.getElementById('paymentImage');
        const paypalLogin = document.getElementById('paypalLogin');

        paymentOptions.forEach(function(option) {
            option.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardDetails.style.display = 'block';
                    paymentImageDiv.style.display = 'none';
                    paypalLogin.style.display = 'none';
                } else if (this.value === 'paypal') {
                    creditCardDetails.style.display = 'none';
                    paymentImageDiv.style.display = 'none';
                    paypalLogin.style.display = 'block';
                } else {
                    creditCardDetails.style.display = 'none';
                    paymentImageDiv.style.display = 'block';
                    paypalLogin.style.display = 'none';
                }
            });
        });
    });
    </script>

</body>


</html>
