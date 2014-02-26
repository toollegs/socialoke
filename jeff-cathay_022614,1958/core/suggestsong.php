<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
</head>
<body>
<?php

include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/globals.php');

$url=startPage("suggestsong");
$host=ucfirst($url['host']);
$ph = session_get('ph');
$song = $_POST['song'];
$artist = $_POST['artist'];
doSMS($destphones,"A karaoke version of ".$song." by ".$artist." has been requested!");

echo "<center>".$host." will try to get a karaoke version of ".$song." by ".$artist."!</center>";
?>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/jeff-cathay_022614,1958/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/jeff-cathay_022614,1958/core/assets/footer.php'); ?>
</body>
</html>
