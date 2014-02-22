<?php
	$pn = array();
	$pn2SongCount = array();
	$f = glob("/usr/logs/mysocialoke/archives/*");
	$index = 0;
	foreach($f as $hg) {
		$g = glob($hg."/*");
		if (count($g) > 0) {
			foreach($g as $afile) {
				$afileLines = file($afile);
				$index += count($afileLines);
				foreach($afileLines as $line) {
					$aflArr = explode("||",$line);
					for($i = 0; $i < 3; $i++) {
						$aflArr[$i] = str_replace('-','',$aflArr[$i]);
						$aflArr[$i] = str_replace(' ','',$aflArr[$i]);
						if (!is_numeric($aflArr[$i])) {
							$pn[] = $aflArr[$i];
							if (!isset($pn2SongCount[base64_decode($aflArr[$i])])) {
								$pn2SongCount[base64_decode($aflArr[$i])] = 1;
							} else {
								$pn2SongCount[base64_decode($aflArr[$i])]++;
							}	
							break;
						}
					}
				}
			}
		}
	}
	sort($pn);
	$pn = array_unique($pn);
	$final = array();
	foreach($pn as $ePhone) {
		$ph = base64_decode($ePhone);
		if (is_numeric($ph) && strlen($ph) == 11) {
			echo "Phone Number: ".$ph.", songs: ".$pn2SongCount[$ph]."<br/>";
			$final[$ph] = $pn2SongCount[$ph];
		}
	}
	echo $index." songs received.<br/>";
	echo count($final)." real phone numbers collected.<br/>";
?>
