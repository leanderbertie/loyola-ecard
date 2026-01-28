<?php 
session_start();
if(!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'student') {
    header("Location: ../index.php?err=Student access required");
    exit();
}
$logged_in_user = $_SESSION['username'];
include "../../backend/db_conn.php";
include "../../vendor/autoload.php"; // Include Stripe PHP SDK
$fetch_user_balance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students_data WHERE dept_no='$logged_in_user'"));

// Stripe public key
$stripe_public_key = ' ';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Top Up Balance | Loyola eCard</title>
    <link rel="stylesheet" href="../styles/common.css" />
    <link rel="stylesheet" href="./styles/index.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <!-- Navigation -->
        <div class="main">
            <div class="head">
                <a href="#" class="logo">Loyola eCard</a>
                <nav class="nav-menu">
                    <a href="index.php" class="nav-link">
                        <i class="fa-solid fa-home"></i>
                        Dashboard
                    </a>
                    <a href="topup.php" class="nav-link active">
                        <i class="fa-solid fa-wallet"></i>
                        Top-up
                    </a>
                </nav>
                <div class="user-info">
                    <p>User: <?php echo htmlspecialchars($logged_in_user); ?></p>
                    <a href="../../backend/process_logout.php" class="logout-btn">
                        <i class="fa-solid fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Top Up Form -->
       
        <div class="main">
            <div class="topup-container">
                <div class="topup-header">
                    <i class="fa-solid fa-wallet"></i>
                    <h2>Top Up Balance</h2>
                </div>
                
                <div class="current-balance">
                    Current Balance: ₹<?php echo number_format($fetch_user_balance['balance'], 2); ?>
                </div>
                
                <form id="payment-form" action="checkout.php" method="POST" class="topup-form">
                    <div class="form-group">
                        <label>Amount to Top Up (₹)</label>
                        <input type="number" 
                               name="amount" 
                               id="amount" 
                               min="100" 
                               step="100" 
                               placeholder="Enter amount" 
                               required>
                    </div>
                    <button type="submit" class="topup-button">
                        + Top Up Now
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>
