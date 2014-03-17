<?php

include '../sql.php';

$whichTest = $argv[1];
switch($whichTest) {
	case "insert":
		testInsert();
		break;
	case "update":
		testUpdate();
		break;
	case "select":
		testSelect();
		break;
	case "delete":
		testDelete();
		break;
}

function testInsert()
{
	$result = sqlUpdate("insert into song(name,artist) values ('blah','blah')");
	echo $result.PHP_EOL;
}

function testUpdate()
{
	$result = sqlUpdate("update song set name='blah2' where artist='blah'");
	echo $result.PHP_EOL;
}

function testSelect()
{
	$result = sqlSelect("select name from song where artist='blah'");
	
	var_dump($result);
}

function testDelete()
{
	$result = sqlUpdate("delete from song where artist='blah'");
	echo $result.PHP_EOL;
}
