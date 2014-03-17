<?php

include '/var/www/html/beta/core/globals.php';

if (!isset($_GET['m']) || !isset($_GET['fv'])) {
	return;
}

$msg = $_GET['m'];
$v = $_GET['fv'];

$fn = '/var/www/html/beta/core/dboard/msgcnt.'.$v;
$f = file($fn);
echo count($f);
if (isset($f) && count($f) > 2) {
	echo "Message All Expired!";
} else {
	file_put_contents($fn,'sent'.PHP_EOL,FILE_APPEND | LOCK_EX);
	$fn = '/usr/logs/mysocialoke/venuesOn/'.$v;
	$f = file($fn);
	$pn = array();

	foreach($f as $line) {
		$lArr = explode('||',$line);
		$pn[] = base64_decode($lArr[1]);
	}

	$pn = array_unique($pn);

	foreach($pn as $phone) {
//		doSMS($phone,$msg);
	}
}
