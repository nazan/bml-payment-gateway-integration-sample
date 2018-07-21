<?php

require_once("init.php");

use aharen\Pay\Gateway;
use aharen\Pay\Exceptions\SignatureMissmatchException;

$txnId = $_SESSION['txnId'];
$txnAmount = $_SESSION['MYORDER_'.$txnId];

// this initiates MPG
$config = [
    'Host'        => BML_GATEWAY_END_POINT,
    'MerRespURL'  => MY_CALLBACK_URI,
    'AcqID'       => ACQ_ID,
    'MerID'       => MERCH_ID,
    'MerPassword' => MERCH_PASS
];

$gateway = new Gateway('MPG');

try {
    $r = $gateway->config($config)->callback($_POST, $txnId);

    die("Order placed successfully: ORDER ID: $txnId, ORDER AMOUNT: MVR $txnAmount<br><a href=\"/\">Place another order.</a>");
} catch(SignatureMissmatchException $excp) {
    die('Signature mismatch: ' . $excp->getMessage());
}