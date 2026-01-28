<?php
header('Content-Type: application/json');
include "./db_conn.php";

$api_key = "leander";

if ($api_key == strval($_GET["apikey"])) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $card_number = sanitizeInput($_GET["card_number"]);

        $fetch_sql = "SELECT * FROM students_data where card_number='$card_number'";
        $fetch_res = mysqli_query($conn, $fetch_sql);

        if (mysqli_num_rows($fetch_res) > 0) {
            while ($card = mysqli_fetch_assoc($fetch_res)) {
                $card_balance = $card['balance'];
                $card_new_balance = $card_balance;

                $check_transation = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from payment where reads_card=0 ORDER BY `payment`.`payment_id` DESC LIMIT 1"));
                if (!is_null($check_transation)) {
                    $amount_to_pay = $check_transation['amount'];
                    $transaction_id = $check_transation['transaction_id'];
                    $payment_type = $check_transation['transaction_type'];

                    if ($payment_type == "debit") {
                        if ($card_balance < $amount_to_pay) {
                            echo json_encode(["status" => "error", "message" => "Insufficient fund, balance = #" . $card_new_balance]);
                            exit;
                        } else {
                            $card_new_balance = $card_balance - $amount_to_pay;
                            updateBalance($conn, $card_number, $amount_to_pay, $card_balance, $card_new_balance, "Payment is successful", "1", $transaction_id);
                        }
                    } else if ($payment_type == "credit") {
                        $card_new_balance = $card_balance + $amount_to_pay;
                        updateBalance($conn, $card_number, $amount_to_pay, $card_balance, $card_new_balance, "Account credited ".$card_new_balance, "0", $transaction_id);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "No amount stated"]);
                    exit;
                }
            }
        } else {
          // Store the unregistered card in temp_cards
$insert_temp_card = "INSERT INTO temp_cards (card_number, created_at) VALUES ('$card_number', NOW())";
mysqli_query($conn, $insert_temp_card);

echo json_encode([
    "status" => "error",
    "message" => "Card not Registered",
    "redirect" => "newuser.php"
]);

        }

        $conn->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid method of sending data"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Incorrect Api Key"]);
    exit;
}

function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

function updateBalance($dbConn, $cardNumber, $amount, $previousBalance, $currentBalance, $returnMessage, $transactionType, $transactionId) {
    $update_sql = "UPDATE students_data SET balance='$currentBalance' where card_number='$cardNumber'";
    $log_update = "INSERT into logs (card_number, transaction_type, amount, previous_balance, balance) VALUEs ('$cardNumber', '$transactionType','$amount', '$previousBalance', '$currentBalance')";
    $transaction_update = "UPDATE payment SET reads_card=1 where transaction_id='$transactionId'";

    if ($dbConn->query($update_sql) === TRUE && $dbConn->query($log_update) === TRUE && $dbConn->query($transaction_update)) {
        echo json_encode([
            "status" => "success",
            "message" => $returnMessage,
            "redirect" => "funduser.php"
        ]);
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating balance", "error" => $dbConn->error]);
        exit;
    }
}
?>