<?php

include '/var/www/html/beta/core/globals.php';

$url = startPage("userinput");

$tparm=$_GET['t'];
$ph=session_get('ph');
$songPieces = explode(' by ',$tparm);
$rnd = n_digit_random(5);
$songPieces[0] = str_replace('%26','&',$songPieces[0]);
//$songPieces[0] = str_replace('\'','&apos;',$songPieces[0]);
$songPieces[1] = str_replace('%26','&',$songPieces[1]);
//$songPieces[1] = str_replace('\'','&apos;',$songPieces[1]);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body>
<div data-role="page" id="home" data-theme="f">
        <div data-role="header" data-position="fixed" data-theme="f">
        <h1>SOCIALOKE</h1>
        </div>
        <div data-role="content"  data-theme="f">
<h3>You're going to sing: <?php echo firstlast($songPieces[0]); ?> by <?php echo firstlast($songPieces[1]); ?></h3>
	<form method=POST action="../m/rc.php" name="mainForm">
		<h3>Your Name: <input name='name' maxlength=40 size=41/></h3><br/>
		<h3>Note To Host(optional): <textarea rows=4 cols=60 name='flirt'></textarea></h3><br/>
		<input type="hidden" name="t" value="<?php echo urlencode(str_replace('&','%26',$songPieces[0].' by '.$songPieces[1])); ?>"/>
		<input type="submit" value="GO!"/>
	</form>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php echo file_get_contents('../assets/footer.php'); ?>
</div>
</body>
</html>
