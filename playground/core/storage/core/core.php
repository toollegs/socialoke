<?php

function queryInit()
{
	if (!$link = mysql_connect('socialoke.cwel6wbekmry.us-east-1.rds.amazonaws.com', 'ctojeff', 'Dec261967')) {

		echo 'Could not connect to mysql';
		exit;
	}

	if (!mysql_select_db('socialoke', $link)) {
		echo 'Could not select database';
		exit;
	}

	return $link;
}

function queryCleanup($result)
{
	mysql_free_result($result);
}
