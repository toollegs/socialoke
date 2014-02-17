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
	<h3><a href="/beta/core/login.php?ph=<?php echo urlencode($fromMO); ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
	<a href="http://www.gorhamproductions.com" rel="external" ><img src="assets/logo-trans.png" width="300" height="115" ></a>
	<div data-role="footer" data-theme="f">
		<div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="assets/socialoke.jpg" width="36" height="36"></a><br />Like Us
                </div>
	</div>
</body>
</html>
