<?php

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	
	foreach($_POST as $key => $val) {
		$valArr = explode("||",urldecode($val));
		$venue = $valArr[0];
		break;
	}
	$fn='/usr/logs/mysocialoke/venuesOn/'.$venue;
	unlink($fn);
	touch($fn);
	foreach($_POST as $key => $val) {
		$valArr = explode("||",$val);
		$venue = $valArr[0];
		unset($valArr[0]);
		$val=implode("||",$valArr);
		$val=str_replace(' - ',' by ',$val);
		file_put_contents($fn,$val.PHP_EOL,FILE_APPEND | LOCK_EX);
	}
?>
