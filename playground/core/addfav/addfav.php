<?php

include_once('/var/www/html/beta/core/globals.php');

$url=startPage("addfav");
$fromMO=session_get('ph');
$s = $_GET['s'];

addToFavs($url['fullvenue'],$s);
