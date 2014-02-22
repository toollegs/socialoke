<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("songs");
$q = $_GET['q'];
$ph=session_get('ph');
$s = 0;
if (isset($_GET['s'])) {
	$s = 1;
}	
$letters = array( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0-9' );
$f = array();
$letter = strtoupper(substr($q,0,1));
if ($s == 1) {
	foreach($letters as $letter) {
		$f[] = file($letter.'.csv');;
	}
} else {
	$f[0] = file($letter.'.csv');
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body> 
<div data-role="page" id="page" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1> <?php echo strtoupper($q); ?> - SONGS</h1>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<div data-role="content"  data-theme="f">	
		<center><h4>Click2Sing!</h4></center>
		<ul id="mylistview" data-role="listview" data-autodividers="true"  data-theme="f">
		<?php
$found = 0;
$i=0;
$li = array();
$liText = array();
foreach($f as $songsForLetter) {
	foreach ($songsForLetter as $song) {
		$songPieces = explode(' - ',$song);
		$songPieces[0] = str_replace('&','%26',$songPieces[0]);
//		$songPieces[0] = str_replace('\'','&apos;',$songPieces[0]);
		$songPieces[1] = str_replace('&','%26',$songPieces[1]);
//		$songPieces[1] = str_replace('\'','&apos;',$songPieces[1]);
		if (stripos($songPieces[0],$q) !== false) {
			$found = 1;
			$smsstring = urlencode(trim($songPieces[0]).' - '.trim($songPieces[1])); 
			$liText[] = $song;
			$i = $i+1;
		}
	}
}
$liText = array_unique($liText);
sort($liText);
$i = 0;
foreach($liText as $t) {
	$href = "/beta/core/sm/sm.php?s=".urlencode(str_replace(' - ',' by ',trim($t)));
	echo '<li data-theme="f" id="a'.$i.'"><a href="'.$href.'" id="a'.$i.'" class="hover">'.$t.'</a></li>';
	$i = $i+1;
}
?>
	</ul>
<?php
if ($found == 0) {
?>
		<center><h3>No matches!</h3></center>
<?php
}
?>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php echo file_get_contents('../assets/footer.php'); ?>
</div>
</body>
</html>
