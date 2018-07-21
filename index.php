<?php

require_once("init.php");

use aharen\Pay\Gateway;

$gateway = new Gateway('MPG');

$txnId = rand(1000, 2000) . '_' . date("ymdHis"); // Simulating the transaction ID.
$_SESSION['txnId'] = $txnId;

$txnAmount = rand(2, 10000); // Simulating transaction amount.
$_SESSION['MYORDER_'.$txnId] = $txnAmount;

$config = [
    'Version'     => '1.1',
    'Host'        => BML_GATEWAY_END_POINT,
    'MerRespURL'  => MY_CALLBACK_URI,
    'AcqID'       => ACQ_ID,
    'MerID'       => MERCH_ID,
    'MerPassword' => MERCH_PASS
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

$postFormAsString = '<form action="'.BML_GATEWAY_END_POINT.'" method="post">
    ' . implode('', $input_fields) . '
    <input type="submit" value="Pay via BML Payment Gateway" />
    </form>';

echo "<p>You owe us: MVR $txnAmount</p>";
echo "<p>Please click the button below, you will be redirected to the bank's payment page.</p>";
echo $postFormAsString;