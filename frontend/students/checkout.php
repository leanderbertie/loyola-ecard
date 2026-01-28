<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'student') {
    header("Location: ../index.php?err=Student access required");
    exit();
}

require __DIR__ . "/../../vendor/autoload.php";
require_once "../../backend/db_conn.php";

// Validate amount
if (!isset($_POST['amount']) || empty($_POST['amount'])) {
    header("Location: topup.php?err=Amount is required");
    exit();
}

$amount = (int)$_POST['amount'];
// Convert to paise if needed
$amount = $amount * 100;

// Initialize Stripe with the correct secret key
$stripe = new \Stripe\StripeClient('sk_test_cEjXShRlZO1YrzP8Txn6Ulya00EhUj1dRS');

try {
    $checkout_session = $stripe->checkout->sessions->create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'inr',
                'product_data' => [
                    'name' => 'Wallet Top-up',
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/loyola_ecard/frontend/students/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/loyola_ecard/frontend/students/topup.php',
    ]);

    // Debug line
    error_log('Stripe session created: ' . $checkout_session->id);

    // Redirect to Stripe Checkout
    header("Location: " . $checkout_session->url);
    exit();

} catch(Exception $e) {
    error_log('Stripe error: ' . $e->getMessage());
    header("Location: topup.php?err=" . urlencode($e->getMessage()));
    exit();
}