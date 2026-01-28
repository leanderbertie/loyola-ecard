<?php 
include "./db_conn.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $amount = $_POST['amount'];
    $transaction_type = $_POST['transaction_type']; // Get transaction type
    $transaction_id = time();
    $reads_card = 0;
    // Add transaction_type to the payment table
    mysqli_query($conn, "INSERT into payment (transaction_id, amount, reads_card, transaction_type) 
                        VALUES ('$transaction_id', '$amount', '0', '$transaction_type')");

    header("Location: ../Frontend/approved_transaction_page.html");
}
?>