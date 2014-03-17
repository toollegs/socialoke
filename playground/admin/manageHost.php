<?php

include '/var/www/html/beta/core/globals.php';

var_dumper($_POST);

if (isset($_POST['adu1'])) {
	$add=$_POST['adu1'];
}
if (isset($_POST['adu2'])) {
	$del=$_POST['adu2'];
}
if (isset($_POST['name'])) {
	$name=$_POST['name'];
}
if (isset($_POST['sname'])) {
	$sname=$_POST['sname'];
}
if (isset($_POST['venue'])) {
	$venue=$_POST['venue'];
}
$days = array();
if (isset($_POST['sun'])) {
	$days[]='sun';
}
if (isset($_POST['mon'])) {
	$days[]='mon';
}
if (isset($_POST['tue'])) {
	$days[]='tue';
}
if (isset($_POST['wed'])) {
	$days[]='wed';
}
if (isset($_POST['thu'])) {
	$days[]='thu';
}
if (isset($_POST['fri'])) {
	$days[]='fri';
}
if (isset($_POST['sat'])) {
	$days[]='sat';
}
if (isset($_POST['phone'])) {
	$phone=$_POST['phone'];
}

if (isset($add)) {
	$smsstring = $add;
	$smsstring .= '+'.trim($name);
	$smsstring .= '+'.trim($venue);
	foreach ($days as $day) {
		$smsstring .= '+'.trim($day);
	}
	$smsstring .= '+'.trim($phone);
} else if (isset($del)) {
	$compSname = trim(str_replace("-",",",$sname));
	echo "compSname: '".$compSname."'";
	$f = file("/var/www/html/beta/core/knownHosts");
	$i = 0;
	foreach($f as $line) {
		$f[$i] = trim($line);
		$i++;
	}
	var_dumper($f);
	if (in_array($compSname,$f)) {
		$smsstring = $del;
		$csNameArr = explode(",",$compSname);
		$smsstring .= '+'.trim($csNameArr[0]);
	}
}
if (isset($smsstring)) {
	echo "smsstring: ".$smsstring."<br/>";
	$url = 'http://s-oke.com/beta/core/msgng/sms_handler.php?from=16179706735&text='.$smsstring;
	echo "url: ".$url."<br/>";
	$f=file($url);
	echo $f;
}
?>
