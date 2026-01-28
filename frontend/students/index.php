<?php 
session_start();
if(isset($_SESSION['username']) && $_SESSION['user_type'] === 'student') {
    $logged_in_user = $_SESSION['username'];
    include "../../backend/db_conn.php";
    $fetch_user_balance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students_data WHERE dept_no='$logged_in_user'"));
    $fetch_logs = mysqli_query($conn, "SELECT t1.log_id, t1.card_number, t2.name, t2.dept_no, 
        t1.transaction_type, t1.amount, t1.previous_balance, t1.balance, t1.time 
        FROM logs as t1 
        LEFT JOIN students_data as t2 on t1.card_number = t2.card_number 
        WHERE t2.dept_no='$logged_in_user'
        ORDER BY t1.time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Dashboard | Loyola eCard</title>
    <link rel="stylesheet" href="../styles/common.css" />
    <link rel="stylesheet" href="./styles/index.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <!-- Top Navigation -->
        <div class="main">
    <div class="head">
        <a href="#" class="logo">Loyola eCard</a>
        <nav class="nav-menu">
            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-home"></i>
                Dashboard
            </a>
            <a href="topup.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'topup.php' ? 'active' : ''; ?>">
                <i class="fa-solid fa-wallet"></i>
                Top-up
            </a>
        </nav>
        <div class="user-info">
            <p>User: <?php echo htmlspecialchars($logged_in_user); ?></p>
            <a href="../../backend/process_logout.php">
                <button class="logout-btn">
                    <i class="fa-solid fa-sign-out-alt"></i>
                    Logout
                </button>
            </a>
        </div>
    </div>
        <!-- Rest of your existing code -->
    </div>

        <main class="main-content">
            <!-- Balance Card -->
            <div class="balance-card">
                <div class="balance-header">
                    <i class="fa-solid fa-wallet"></i>
                    <h2>Current Balance</h2>
                </div>
                <div class="balance-amount">
                    ₹<?php echo number_format($fetch_user_balance['balance'], 2); ?>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="tables-container">
                <!-- Transaction History -->
                <div class="transaction-history">
                    <h2>
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Transaction History
                    </h2>
                    <div class="table-container">
                        <table class="transaction-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Previous Balance</th>
                                    <th>Amount</th>
                                    <th>Current Balance</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 1;
                                while($res = mysqli_fetch_assoc($fetch_logs)){
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo htmlspecialchars($res['name']); ?></td>
                                    <td class="<?php echo ($res['transaction_type'] == '0') ? 'credit' : 'debit'; ?>">
                                        <?php echo ($res['transaction_type'] == '0') ? "Credit" : "Debit"; ?>
                                    </td>
                                    <td>₹<?php echo number_format($res['previous_balance'], 2); ?></td>
                                    <td>₹<?php echo number_format($res['amount'], 2); ?></td>
                                    <td>₹<?php echo number_format($res['balance'], 2); ?></td>
                                    <td><?php echo date('d M Y, h:i A', strtotime($res['time'])); ?></td>
                                </tr>
                                <?php $sn++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top-up History -->
                <div class="transaction-history">
                    <h2>
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        Top-up History
                    </h2>
                    <div class="table-container">
                        <table class="transaction-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $topup_logs = mysqli_query($conn, "SELECT * FROM transactions 
                                    WHERE student_id='$logged_in_user' 
                                    AND transaction_type='topup'
                                    ORDER BY id DESC");
                                
                                $sn = 1;
                                while($topup = mysqli_fetch_assoc($topup_logs)){
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td>₹<?php echo number_format($topup['amount'], 2); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo strtolower($topup['status']); ?>">
                                            <?php echo ucfirst($topup['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($topup['description']); ?></td>
                                    <td><?php 
                                        $timestamp = strtotime($topup['created_at'] ?? $topup['time'] ?? 'now');
                                        echo date('d M Y, h:i A', $timestamp); 
                                    ?></td>
                                </tr>
                                <?php $sn++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <?php if(isset($_GET['payment']) && $_GET['payment'] === 'success'): ?>
    <script>
        // Show success message
        alert('Payment successful! Amount added: ₹<?php echo number_format($_GET['amount'], 2); ?>');
        // Remove the query parameters
        window.history.replaceState({}, document.title, 'index.php');
    </script>
    <?php endif; ?>
</body>
</html> 
<?php } else {
    header("Location: ../index.php");
    exit();
} ?> 