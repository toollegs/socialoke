<?php
	echo "Active Gigs<br/>";
	foreach (glob("/usr/logs/mysocialoke/venuesOn/*") as $filename) {
		$fnArr = explode('/',$filename);
		$v = trim($fnArr[count($fnArr) - 1]);
		echo "venue: ".$v."<br/>";
	}
?>
