<?php
	$f = file('all.csv');
	$json = array();
	file_put_contents('songs.json','');
	foreach ($f as $line) {
		$line=trim($line);
		$fArr = explode(' - ',$line);
		$song = trim($fArr[0]);
		$artist = trim($fArr[1]);
		$songNode['song'] = $song;
		$songNode['p']=0;
		$songNode['d']=0;
		$json[$artist][] = $songNode;
	}
	ksort($json);
	file_put_contents('songs.json',json_encode($json),FILE_APPEND | LOCK_EX);
	echo "Done.";
?>
