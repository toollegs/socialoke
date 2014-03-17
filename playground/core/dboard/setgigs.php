<?php

include_once('/var/www/html/beta/core/globals.php');

$host = $_GET['h'];
if (isset($_GET['sc'])) {
	$sc = $_GET['sc'];
}
$hostUpper = strtoupper($_GET['h']);

$f = file("/usr/logs/mysocialoke/giglists/".$host);
$venues = explode(',',$f[0]);
$ret = makeSelect("sun","SUNDAY",1);
$ret .= makeSelect("mon","MONDAY",2);
$ret .= makeSelect("tue","TUESDAY",3);
$ret .= makeSelect("wed","WEDNESDAY",4);
$ret .= makeSelect("thu","THURSDAY",5);
$ret .= makeSelect("fri","FRIDAY",6);
$ret .= makeSelect("sat","SATURDAY",7);

function makeSelect($sName,$dayStr,$i)
{
	global $venues;
	global $f;
	$ret = "<select name=\"".$sName."\" id=\"d-".$sName."\">";	
	$ret .= "<option value=\"\">SELECT ".$dayStr." VENUE</option>";
	foreach($venues as $venue) {
		$venue=trim($venue);
		$dv = explode(',',$f[$i]);
		$thisV = trim($dv[1]);
		$selected = "";
		if ($thisV == $venue) {
			$selected = "selected";
		}
		$ret .= "<option value=\"".$venue."\" ".$selected.">".$dayStr.": ".strtoupper($venue)."</option>";
	}
	$ret .= "<option value=\"off\">OFF!</option>";
	$ret .= "</select>";

	return $ret;
}

function getOutput() {
	global $host, $ret, $hostUpper, $sc;

	$fullret .= '<div id="setgigstab"><center><h3>SET GIGS FOR '.$hostUpper.'</h3></center><form id="gigsForm" method="POST" action="/beta/core/dboard/postgigs.php"><input type="hidden" name="h" value="'.$host.'"/>'.$ret.'<br/></br><input type=button value="GO!" name="postgigs" id="postgigs"/></div>';
	if (isset($sc)) {
		$fullret .= '<div id=confirm"><h3>GIGS SET!</div>';
	}
	$fullret.='<script>$( "#postgigs" ).click(function() { var serializedData = $("#gigsForm").serialize(); $.ajax({ url: "/beta/core/dboard/postgigs.php", type: "post", data: serializedData }); });</script>';
	$fullret .= "</div>";
	return $fullret;
}
