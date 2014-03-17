<?php

include 'core/core.php';

function sqlCommit()
{
	$conn = queryInit();

	$result = mysql_query("commit", $conn);

	if (!$result) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error().PHP_EOL;
		exit;
	}

	return $result;
}

function sqlUpdate($sql) {

	$conn = queryInit();

	$result = mysql_query($sql, $conn);

	if (!$result) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error().PHP_EOL;
		exit;
	}

	return $result;
}

function sqlSelect($sql)
{
	$rows = array();
	$conn = queryInit();

	$result = mysql_query($sql, $conn);

	if (!$result) {
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error().PHP_EOL;
		exit;
	}

	while ($row = mysql_fetch_assoc($result)) {
		$rows[] = $row;
	}

	queryCleanup($result);

	return $rows;
}
