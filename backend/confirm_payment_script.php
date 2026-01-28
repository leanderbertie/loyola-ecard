<?php
header('Content-Type: application/json');
include "./db_conn.php";

$check_transation = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from payment where reads_card=0 ORDER BY `payment`.`payment_id` DESC LIMIT 1"));

if ($check_transation) {
    $response = [
        'status' => 'success',
        'redirect' => '../frontend/funduser.php'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Payment not found or already processed'
    ];
}

echo json_encode($response);
?>