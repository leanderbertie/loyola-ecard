<?php 
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $current_page = 'logs';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loyola eCard | Logs</title>
    <link rel="stylesheet" href="./styles/common.css" />
    <link rel="stylesheet" href="./styles/logs.css" />
    <script src="https://kit.fontawesome.com/bef2386e82.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <?php include './components/nav.php'; ?>
        <main class="main-content">
            <header class="top-header">
                <div class="header-content">
                    <h1>Transaction Logs</h1>
                </div>
            </header>

            <div class="logs-content">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="logs-table">
                                <tr>
                                    <th>S/N</th>
                                    <th>Student Name</th>
                                    <th>Department Number</th>
                                    <th>Card Number</th>
                                    <th>Transaction Type</th>
                                    <th>Previous Balance</th>
                                    <th>Amount</th>
                                    <th>Current Balance</th>
                                    <th>Time of Event</th>
                                </tr>
                                <?php
                                include "../backend/db_conn.php";
                                $fetch_logs = mysqli_query($conn, "SELECT t1.log_id, t1.card_number, t2.name, t2.dept_no, t1.transaction_type, t1.amount, t1.previous_balance, t1.balance, t1.time 
                                FROM `logs` as t1 
                                LEFT JOIN students_data as t2 
                                ON t1.card_number = t2.card_number
                                ORDER BY t1.time DESC");
                                
                                $sn = 1;
                                while($res = mysqli_fetch_assoc($fetch_logs)){
                                ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo htmlspecialchars($res['name']); ?></td>
                                    <td><?php echo htmlspecialchars($res['dept_no']); ?></td>
                                    <td><?php echo htmlspecialchars($res['card_number']); ?></td>
                                    <td>
                                        <span class="transaction-type">
                                            <?php echo $res['transaction_type'] == '0' ? 'Credit' : 'Debit'; ?>
                                        </span>
                                    </td>
                                    <td>₹<?php echo number_format($res['previous_balance'], 2); ?></td>
                                    <td>₹<?php echo number_format($res['amount'], 2); ?></td>
                                    <td>₹<?php echo number_format($res['balance'], 2); ?></td>
                                    <td><?php echo date('M d, Y H:i:s', strtotime($res['time'])); ?></td>
                                </tr>
                                <?php $sn++; } ?>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php 
}else{
    header("location: ./index.php");
} 
?>
