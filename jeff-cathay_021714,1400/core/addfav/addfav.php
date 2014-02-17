<?php

include '/var/www/html/beta/jeff-cathay_021714,1400/core/globals.php';

$url=startPage("addfav");
$fromMO=session_get('ph');
$s = $_GET['s'];

addToFavs($url['fullvenue'],$s);
