<?php

session_start();
require_once '../../vendor/autoload.php';

$total = $_POST['total_price'];

\Stripe\Stripe::setApiKey
('sk_test_51BsGTfAZYQ5IkzsXWk59gnCkITp66ipSVWF9liUhekcglDIq9bAIeNKFDJq5agFcSEOdZljaveMQYeKlKLMEuVmV00QGuzSJIX');
$token = $_POST['stripeToken'];

$charge = \Stripe\Charge::create(
    array(
        'amount' => (float)$total*100,
        'currency' => 'cad',
        'source' => $token,
    )
);

header('Location:http://localhost/?msg=success');
exit;