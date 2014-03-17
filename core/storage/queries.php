<?php

include '/var/www/html/beta/core/storage/sql.php';

function persistHost($h,$pn,$c)
{
	$sql = "insert into host(host_company_code,phone_no,name) values('".$c."','".$pn."','".$h."');";
	if (!isset($c)) {
		$sql = "insert into host(phone_no,name) values('".$pn."','".$h."');";
	}

	$result = sqlUpdate($sql);

	return $result;
}

function persistGig($h,$v,$d,$s)
{
	$sql = "insert into host_gig(host_id,venue_code,dow,start_time) values('".$h."','".$v."','".$d."','".$s."');";

	$result = sqlUpdate($sql);
}

function persistLiveGig($h,$v,$d,$d2,$code)
{
	$sql = "insert into gig(host_id,venue_code,date_str,code) values('".$h."','".$v."','".$d."',".$code.");";

	$result = sqlUpdate($sql);

	$sql = "insert into gig(host_id,venue_code,date_str,code) values('".$h."','".$v."','".$d2."','".$code."');";

	$result = sqlUpdate($sql);

	return $result;
}

function getGigStorage($h,$v)
{
	$sql = "select venue_code, host_id, code from gig where host_id='".$h."' and venue_code='".$v."';";

	$result = sqlSelect($sql);

	return $result;
}

function getKnownHostsStorage()
{
	$sql = "select id,phone_no from host";
	$ret = array();
	
	$result = sqlSelect($sql);
	foreach($result as $row) {
		$ret[$row['id']] = $row['phone_no'];
	}

	return $ret;
}
