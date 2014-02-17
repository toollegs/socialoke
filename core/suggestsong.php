<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script></head>
<head><title>Suggestion Sent!</title></head>
<body>
<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("suggestsong");
$host=ucfirst($url['host']);
$ph = session_get('ph');
$song = $_POST['song'];
$artist = $_POST['artist'];
doSMS($destphones,"A karaoke version of ".$song." by ".$artist." has been requested!");

echo "<center>".$host." will try to get a karaoke version of ".$song." by ".$artist."!</center>";
?>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
<?php
include 'assets/footer.php';
?>
</body>
</html>
