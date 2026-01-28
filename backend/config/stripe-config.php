<?php
require_once('../../vendor/autoload.php');

// Set your Stripe secret key
\Stripe\Stripe::setApiKey('sk_test_your_secret_key');

// Set your publishable key (for frontend)
$stripe_publishable_key = 'pk_test_your_publishable_key';
?> 