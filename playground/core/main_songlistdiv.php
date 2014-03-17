<div data-role="page" id="songlist" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1> <?php echo strtoupper($q); ?> - SONGS</h1>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="#home" data-role="button">Back To Main Menu</a></h3>
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
	echo '<li data-theme="f" data-icon="" id="a'.$i.'"><a href="'.$href.'" id="a'.$i.'" class="hover">'.$t.'</a></li>';
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
                <h3><a href="#home" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
