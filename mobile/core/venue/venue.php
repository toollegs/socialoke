<?php

include 'venue_funcs.php';

$f = $_GET['f'];

if (strtolower($f) == 'live') {
	return get_live();
}
?>
