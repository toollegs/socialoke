<?php
include '/var/www/html/beta/core/globals.php';

	$id=$_POST['id'];
	$idArr = explode('-',$id);
	$host = $idArr[1];
	$venueDateArr = explode('_',$idArr[2]);
	$venue=$venueDateArr[0];
	$vDateCode=explode(',',$venueDateArr[1]);
	$vDate = $vDateCode[0];
	$code = $vDateCode[1];
	$rowId = $idArr[3];
	$fullVenue = $host."-".$venue."_".$vDate;
	$fArr = glob("/usr/logs/mysocialoke/venuesOn/".$fullVenue.",*");
	$fvArr=explode("/",$fArr[0]);			
	$fullVenue=$fvArr[count($fvArr)-1];
	$fn = '/usr/logs/mysocialoke/venuesOn/'.$fullVenue;
	$f = file($fn);
	unlink($fn);
	touch($fn);
	$i = 0;
	foreach($f as $line) {
		if ($i != $rowId-1) {
			file_put_contents($fn,$line, FILE_APPEND | LOCK_EX);
		}
		$i = $i + 1;
	}

	header("HTTP/1.1 200 OK");
?>
