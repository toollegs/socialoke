<?php

include_once('/var/www/html/beta/core/globals.php');

$host = $_POST['h'];
$f = file("/usr/logs/mysocialoke/giglists/".$host);

file_put_contents("/usr/logs/mysocialoke/giglists/".$host.".new",$f[0]);
unset($f[0]);
foreach($f as $daygig) {
	$dgArr = explode(',',$daygig);
	$day=$dgArr[0];
	$dayVal = $_POST[$day];
	if (!isset($dayVal) || $dayVal == '') {
		$dayVal = "off";
	}
	$fname = "/usr/logs/mysocialoke/giglists/".$host.".new";
	file_put_contents($fname,$day.",".$dayVal.",20".PHP_EOL, FILE_APPEND | LOCK_EX);
}
unlink("/usr/logs/mysocialoke/giglists/".$host);
rename("/usr/logs/mysocialoke/giglists/".$host.".new", "/usr/logs/mysocialoke/giglists/".$host);
chmod("/usr/logs/mysocialoke/giglists/".$host,0777);
echo "********************************YEP*************************";
?>
