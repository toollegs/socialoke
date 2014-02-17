<?php

include 'songs_funcs.php';

$f = $_GET['f'];
$p1 = '';
if (isset($_GET['p1'])) {
	$p1 = strtolower($_GET['p1']);
}
$p2 = '';
if (isset($_GET['p2'])) {
	$p2 = strtolower($_GET['p2']);
}

header('Content-Type: application/json');
header('Cache-Control: no-cache');

if (strtolower($f) == 'all') {
	return get_all();
}
if (strtolower($f) == 'get') {
	return get($p1,$p2);
}
if (strtolower($f) == 'popular') {
	return popular();
}
if (strtolower($f) == 'duets') {
	return duets();
}
if (strtolower($f) == 'setgenres') {
	return setgenres();
}
?>
