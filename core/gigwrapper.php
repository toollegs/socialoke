
<?php

include '/var/www/html/beta/core/globals.php';

$uri=startPage('gigwrapper');
$fromMO=session_get('ph');
?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
</head>
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
