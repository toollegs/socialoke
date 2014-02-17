<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("asong");
$a = $_GET['a'];
$a = str_replace(':-',' ',$a);
echo "a: ".$a;
$firstletter = strtoupper(substr($a,0,1));
$fromMO=session_get('ph');
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
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $fromMO; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        <a href="http://www.gorhamproductions.com" rel="external"><img src="http://www.gorhamproductions.com/wp-content/uploads/2011/06/Gorham-Productions-logo.jpg" width="300" height="115"></a>
        <div data-role="footer" data-theme="f">
                <div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="../assets/socialoke.jpg" width="36" height="36"></a><br />Like Us</div>
                </div>
        </div>
</div>
</body>
</html>
