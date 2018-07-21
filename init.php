<?php

session_start();

require_once __DIR__.'/vendor/autoload.php';

date_default_timezone_set('Indian/Maldives');

if(!defined('ACQ_ID')) { 
    define('ACQ_ID', '2f88d37ac873');
}

if(!defined('MERCH_ID')) {
    define('MERCH_ID', 'ab38293f3933');
}

if(!defined('MERCH_PASS')) {
    define('MERCH_PASS', 'password123');
}

if(!defined('BML_GATEWAY_END_POINT')) {
    define('BML_GATEWAY_END_POINT', "https://pay.mv");
}

if(!defined('MY_CALLBACK_URI')) {
    define('MY_CALLBACK_URI', "http://localhost:8036/process-callback.php");
}