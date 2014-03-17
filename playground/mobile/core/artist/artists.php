<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("artists");
$q = $_GET['q'];
$s = 0;
if (isset($_GET['s'])) {
	$s = 1;
}	
$fromMO=session_get('ph');

function doSongs($letter,$q)
{
	global $found;
	$f = file('/var/www/html/beta/core/artist/'.strtoupper($letter).'.csv');
	$curArtist = '';
	$newArtist = 1;
	foreach($f as $song) {
		$songPieces = explode(' - ',$song);
#		$songPieces[0] = str_replace('&','%26',$songPieces[0]);
#		$songPieces[0] = str_replace('\'','&apos;',$songPieces[0]);
#		$songPieces[1] = str_replace('&','%26;',$songPieces[1]);
#		$songPieces[1] = str_replace('\'','&apos;',$songPieces[1]);
		$q = strtolower($q);
//		echo "q: ".$q.", sp: ".$songPieces[0].", pos: ".strpos($songPieces[0],$q)."<br/>";
		if (strpos(strtolower($songPieces[0]),strtolower($q)) !== false) {
			if ($found == 0) {
			?>
		<?php
			}
			$found = 1;
			if ($curArtist != $songPieces[0]) {
				$curArtist = $songPieces[0];
				$newArtist = 1;
			} else {
				$newArtist = 0;
			}
			$asMap[$curArtist][] = trim($songPieces[1]);
	
			if ($newArtist == 1) {
		?>
			<li data-theme="f"><a href="/beta/core/a/as.php?a=<?php echo $curArtist; ?>" class="hover"><?php echo $curArtist; ?></a></li>
		<?php
			}
		}
	}
}
?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<title>Gorham Productions</title>
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="css/jquery.mobile.alphascroll.css" />
<script type="text/javascript" src="js/jquery.mobile.alphascroll.js"></script>
<script>$( document ).ready( function() { 
$( '#mylistview' ).listview( 'refresh' ).alphascroll();
})</script>-->
</head> 
<body> 

<div data-role="page" id="page" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      <h1> <?php echo strtoupper($q); ?> - ARTISTS</h1>
	</div>
	<div data-role="content"  data-theme="f">
		<center><h4>Click2Sing!</h4></center>
		<ul id="mylistview" data-role="listview" data-autodividers="true"  data-theme="f">
		<?php
$letters = array( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0-9' );
$artistdivs = array();
$found = 0;
$letter = strtoupper(substr($q,0,1));
if ($s == 1) {
foreach($letters as $letter) {
	doSongs($letter,$q);
}
} else {
	doSongs($letter,$q);
}
?>
</ul>		

<?php
if ($found == 0) {
?>
		<center><h3>No matches!</h3></center>
        </div>
<?php
}
?>
	</div>
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $fromMO; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        <a href="http://www.gorhamproductions.com" rel="external"><img src="http://www.gorhamproductions.com/wp-content/uploads/2011/06/Gorham-Productions-logo.jpg" width="300" height="115"></a>
        <div data-role="footer" data-theme="f">
                <div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="/beta/core/assets/socialoke.jpg" width="36" height="36"></a><br />Like Us</div>
                </div>
        </div>
</div>
</body>
</html>
