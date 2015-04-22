<?php

// activate full error reporting
//error_reporting(E_ALL & E_STRICT);

include 'XMPPHP/XMPPHP_BOSH.php';

#Use XMPPHP_Log::LEVEL_VERBOSE to get more logging for error reports
#If this doesn't work, are you running 64-bit PHP with < 5.2.6?
$conn = new XMPP('beta.unitedempires.com', 5222, 'orin', 'orin', 'xmpphp', 'beta.unitedempires.com', $printlog=False, $loglevel=LOGGING_INFO);
try {
    $conn->connect();
    $conn->processUntil('session_start');
    $conn->presence();
    $conn->message('gaja@beta.unitedempires.com', 'This is a test message!');
    $conn->disconnect();
} catch(XMPPHP_Exception $e) {
    die($e->getMessage());
}
