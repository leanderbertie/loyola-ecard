<?php 
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $current_page = 'dashboard';
    include "../backend/db_conn.php";
    $fetch_total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students_data where dept_no!='admin'"));
    $fetch_total_transactions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM logs"));
    $fetch_total_credit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM logs where transaction_type='0'"));
    $fetch_total_debit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM logs where transaction_type='1'"));
    $current_month = date('m');
    $current_year = date('Y');
    $fetch_month_total = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT SUM(amount) as total 
         FROM logs 
         WHERE MONTH(time) = '$current_month' 
         AND YEAR(time) = '$current_year' 
         AND transaction_type = '1'")); // type 1 for debit/payments
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | Dashboard</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/dashboard.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <?php include './components/nav.php'; ?>
        <main class="main-content">
            <div class="dashboard-content">
                <section class="stats-overview">
                    <h2>Overview</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon users">
                                <i class="fa-solid fa-users-viewfinder"></i>
                            </div>
                            <div class="stat-details">
                                <h3>Total Users</h3>
                                <p><?php echo $fetch_total_users['total']; ?></p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon transactions">
                                <i class="fa-solid fa-address-book"></i>
                            </div>
                            <div class="stat-details">
                                <h3>Transactions</h3>
                                <p><?php echo $fetch_total_transactions['total']; ?></p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon credits">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                            </div>
                            <div class="stat-details">
                                <h3>Total Credits</h3>
                                <p><?php echo $fetch_total_credit['total']; ?></p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon debits">
                                <i class="fa-solid fa-arrow-trend-down"></i>
                            </div>
                            <div class="stat-details">
                                <h3>Total Debits</h3>
                                <p><?php echo $fetch_total_debit['total']; ?></p>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="stat-card">
                            <div class="stat-icon debits">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="stat-details">
                            <h3>This Month's Total</h3>
                            <p class="stats-number">₹<?php echo number_format($fetch_month_total['total'], 2); ?></p>
                            <p class="stats-label"><?php echo date('F Y'); ?></p>
                            </div>
                        </div>
                </div>
            </div>
        </main>
    </div>
</body>