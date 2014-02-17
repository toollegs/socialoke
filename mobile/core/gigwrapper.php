
<?php

include '/var/www/html/beta/core/globals.php';

$uri=startPage('gigwrapper');
$fromMO=session_get('ph');
?>

<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.gorhamproductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script></head>
<body>
	<h3><a href="http://mysocialoke.com/beta/core/main.php?ph=<?php echo $fromMO; ?>" data-role="button">Back</a></h3>
	<?php
		$v = $_GET['v'];
		$f = file_get_contents($v);
		echo $f;	
	?>
	<h3><a href="http://mysocialoke.com/beta/core/main.php?ph=<?php echo $fromMO; ?>" data-role="button">Back</a></h3>
</body>
</html> 
