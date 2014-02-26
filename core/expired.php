<?php
	include_once('/var/www/html/beta/core/globals.php');
	$uri=startPage('expired');
	$ph=urlencode(session_get('ph'));
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
</head>
<body>
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      <!--<img src="Gorham-Productions-logo-small.jpg"/>-->
	</div>
	<div data-role="content" data-theme="f">
		<h3><center>YOU HAVE REACHED THIS PAGE IN ERROR!</center></h3>
		<a href="/beta/core/login.php?ph=<?php echo $ph; ?>" data-role="button">Please return to Wifi Karaoke by clicking here</a>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>

</body>
</html>
