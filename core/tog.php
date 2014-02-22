<?php
	$tStr = "http://s-oke.com/beta/core/msgng/sms_handler.php?from=".urlencode(base64_decode($_GET['p']))."&text=".urlencode($_GET['h']." ".$_GET['v']." on");
	$file=file_get_contents($tStr);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
</head>
<body>
<div data-role="page" id="home" data-theme="f">
Your gig at <?php echo $_GET['v'] ?> is now on.  Please close this window.
</div>
</body>
</html>

