<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("asong");
$a = $_GET['a'];
$a = str_replace(':-',' ',$a);
echo "a: ".$a;
$firstletter = strtoupper(substr($a,0,1));
$ph=session_get('ph');
$f = file('/var/www/html/beta/core/artist/'.$firstletter.'.csv');
$songs = array();
foreach($f as $song) {
	if (startsWith($song, $a) !== FALSE) {
		$songs[] = $song;
	}
}
sort($songs);
?>
<!DOCTYPE html><html><head>"/><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" /><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script></head> 
<body> 
<div data-role="page" id="<?php echo str_replace(' ',':-',$key); ?>" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1><?php echo strtoupper(firstlast($a)); ?></h1>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<div data-role="content" data-theme="f">	
	<ul id="mylistviews" data-role="listview" data-theme="f">
<?php
		foreach($songs as $song) {
		$songArr = explode(' - ',$song);
		$justartist = trim($songArr[0]);
		$justsong = trim($songArr[1]);
		$smsstring = str_replace('&','%26',$justsong.' by '.$justartist); 
//		$smsstring = str_replace('%26amp%3B','and',$smsstring);
//		$smsstring = str_replace('%26apos%3B','',$smsstring);
		$href = "/beta/core/sm/sm.php?s=".str_replace(' - ','+by+',$smsstring);
?>
		<li data-theme="f"><a href="<?php echo $href ?>" class="hover"><?php echo $justsong; ?></a></li>
<?php
		}
?>
	</ul>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
<?php echo file_get_contents('../assets/footer.php'); ?>

</div>
</body>
</html>
