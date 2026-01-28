<?php
session_start();
require __DIR__ . "/../../vendor/autoload.php";
require_once "../../backend/db_conn.php";

$stripe = new \Stripe\StripeClient('');

// Retrieve the session ID from URL
if (isset($_GET['session_id'])) {
    try {
        // Retrieve the session with line items expanded
        $session = $stripe->checkout->sessions->retrieve(
            $_GET['session_id'],
            ['expand' => ['line_items']]
        );
        
        if ($session->payment_status === 'paid') {
            // Get the amount directly from the session
            $total_amount = $session->amount_total / 100; // Convert from paise to rupees
            
            // Update student balance
            $stmt = $conn->prepare("UPDATE students_data SET balance = balance + ? WHERE dept_no = ?");
            $stmt->bind_param("ds", $total_amount, $_SESSION['username']);
            $stmt->execute();
            
            // Record the transaction - using only the columns that exist
            $stmt = $conn->prepare("INSERT INTO transactions (
                student_id, 
                amount, 
                transaction_type, 
                description, 
                stripe_session_id, 
                status
            ) VALUES (?, ?, 'topup', ?, ?, 'completed')");
            
            $description = "Wallet top-up payment";

            $stmt->bind_param("sdss", 
                $_SESSION['username'],
                $total_amount,
                $description,
                $session->id
            );
            $stmt->execute();
            
            $success = true;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        error_log('Stripe Error: ' . $error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <meta charset="UTF-8" />
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .success-message {
            color: #4CAF50;
            font-size: 18px;
            margin: 20px 0;
        }
        .error-message {
            color: #f44336;
            font-size: 18px;
            margin: 20px 0;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Status</h1>
        <?php if (isset($success)): ?>
            <div class="success-message">
                <p>Thank you for your payment! Your balance has been updated.</p>
                <div class="amount">Amount added: ₹<?php echo number_format($total_amount, 2); ?></div>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="error-message">
                <p>Error: <?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php else: ?>
            <div class="error-message">
                <p>Invalid session ID or payment not completed.</p>
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="back-link">Return to Home</a>
    </div>
</body>
</html>