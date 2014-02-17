<?php
	$host = $_GET['h'];
	$day=strtolower(date('D'));
	$f = file('/usr/logs/mysocialoke/giglists/'.$host);
	unset($f[0]);
	foreach($f as $line) {
		$lineArr = explode(',',$line);
		if ($lineArr[0] == $day) {
			$venue = $lineArr[1];
		}
	}
	$fullVenue = $host.'-'.trim($venue).'_'.date('mdy');
	$f = file('/usr/logs/mysocialoke/venuesOn/'.$fullVenue);
?>
<table id="queueTbl" width="80%" border=1>
	<tr><th colspan=5>Tonight's Current Queue</th></tr>	
	<tr><th style="text-align:left;">Hash</th><th style="text-align:left;">Singer</th><th style="text-align:left;">Song</th><th style="text-align:left;">Artist</th><th style="text-align:left;">Note</th></tr>
	<?php $i = 1; foreach($f as $row) { 
		$rowArr=explode(':',$row);
		$key=$rowArr[0];
		$singer=$rowArr[1];
		$saArr = explode(' - ',$rowArr[2]);
		$song = $saArr[0];
		$artist = $saArr[1];
		$note = trim($rowArr[3]);
	?>
	<tr id="<?php echo $i ?>"><td><?php echo $key ?></td><td><?php echo $singer ?></td><td><?php echo $song ?><td><?php echo $artist ?></td><td><?php echo $note ?></td><td><input type="button" id="removeBtn-<?php echo $fullVenue."-".$i ?>" value="remove"/></td><td><input type="hidden" name="row-<?php echo $i ?>" value='<?php echo $fullVenue.":".$key.":".$singer.":".$song." - ".$artist.":".$note ?>'/></td></tr>
	<?php $i = $i+1; } ?>
</table>
