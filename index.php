<?php

session_start();

require_once __DIR__.'/vendor/autoload.php';

date_default_timezone_set('Indian/Maldives');


use aharen\Pay\Gateway;
use aharen\Pay\Exceptions\SignatureMissmatchException;

$gateway = new Gateway('MPG');

$orderId = rand(1000, 2000); // simulating an orderId;
$_SESSION['orderId'] = $orderId;

$txnId = $orderId.'_'.date("ymd"); // date suffix is not required.
$_SESSION['txnId'] = $txnId;

$txnAmount = rand(2, 10000);
$_SESSION['txnAmount'] = $txnAmount;

$callbackUrl = "https://localhost:8036/process-callback.php"; // replace here with your actual callback url.

$callbackUrl = str_replace('https:', 'http:', $callbackUrl);

if(strpos($callbackUrl, '?') !== false) {
    $callbackUrl .= '&';
} else {
    $callbackUrl .= '?';
}

$callbackUrl = $callbackUrl . "order_id=$orderId&txn_id=$txnId";

$paymentGatewayUrl = "https://pay.mv";

$config = [
    'Version'     => '1.1',
    'Host'        => $paymentGatewayUrl,
    'MerRespURL'  => $callbackUrl,
    'AcqID'       => '2f88d37ac873',
    'MerID'       => 'ab38293f3933',
    'MerPassword' => 'password123'
];

$gateway->config($config);

$gateway->transaction($txnAmount, $txnId);

// Below call returns an associtive array.
// keys of array are HTTP POST parameters.
// values of array are HTTP POST parameter values.
$post_body_as_associative_array = $gateway->get();


// use following code to generate your view.
$input_fields = array();
foreach($post_body_as_associative_array as $key => $value){
    $input_fields[] = "<input type='hidden' name='$key' value='$value'/>";
}

$postFormAsString = '<form action="'.$paymentGatewayUrl.'" method="post">
    ' . implode('', $input_fields) . '
    <input type="submit" value="Pay via BML Payment Gateway" />
    </form>';

echo $postFormAsString;