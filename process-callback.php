<?php

session_start();

require_once __DIR__.'/vendor/autoload.php';

date_default_timezone_set('Indian/Maldives');

use aharen\Pay\Gateway;
use aharen\Pay\Exceptions\SignatureMissmatchException;


$orderId = $_SESSION['orderId'];

$txnId = $_SESSION['txnId'];

$txnAmount = $_SESSION['txnAmount'];

$paymentGatewayUrl = "https://pay.mv";
$callbackUrl = "http://localhost:8036/process-callback.php?order_id=$orderId&txn_id=$txnId"; // replace here with your actual callback url.

// this initiates MPG
$config = [
    'Host'        => $paymentGatewayUrl,
    'MerRespURL'  => $callbackUrl,
    'AcqID'       => '2f88d37ac873',
    'MerID'       => 'ab38293f3933',
    'MerPassword' => 'password123'
];

$gateway = new Gateway('MPG');

try {
    $r = $gateway->config($config)->callback($_POST, $txnId);
    die("Payment is completed successfully.");
} catch(SignatureMissmatchException $excp) {
    die('Signature mismatch: ' . $excp->getMessage());
}