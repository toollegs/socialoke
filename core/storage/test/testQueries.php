<?php

include '../queries.php';

function testGetKnownHostsStorage()
{
	$result = getKnownHostsStorage();

	var_dump($result);
}

testGetKnownHostsStorage();
