<?php

include '/var/www/html/playground/mobile/core/globals.php';

$venues = file('/var/www/html/playground/mobile/core/knownVenues');
$jVenues = array();
foreach ($venues as $jVenue) {
	$jVenueArr = explode(',',trim($jVenue));
	$codes = array_slice($jVenueArr,0,count($jVenueArr)-1);
	$jVenues[trim($jVenueArr[0])]['name'] = $codes[0];
	$jVenues[trim($jVenueArr[0])]['codes'] = $codes;
	$jVenues[trim($jVenueArr[0])]['fb'] = $jVenueArr[count($jVenueArr)-1];
	
}

$venues = array();

function get_live()
{
	global $jVenues;
	$f = glob("/usr/logs/mysocialoke/venuesOn/*");
	foreach($f as $onVenue) {
		$fArr = explode('-',trim($onVenue));
		$vArr = explode('_',$fArr[1]);
		$venues[] = trim($vArr[0]);
	}
	if (isset($venues) && count($venues) > 0) {
		$retVenues = array();
		$venues = array_unique($venues);
		foreach($venues as $v) {
			$retVenues[] = $jVenues[$v];
			
		}
	}
	if (isset($retVenues)) {
		echo json_encode($retVenues);
	}
}
?>
