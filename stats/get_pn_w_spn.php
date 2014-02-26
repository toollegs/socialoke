<?php
	$pn = array();
	$pn2SongCount = array();
	$f = glob("/usr/logs/mysocialoke/archives/*");
	$perVenue = array();
	$index = 0;
	foreach($f as $hg) {
		$g = glob($hg."/*");
		if (count($g) > 0) {
			foreach($g as $afile) {
				if (strpos($afile,'vote') !== FALSE) {
					break;
				}
				$afileLines = file($afile);
				$aflArr = explode('/',$afile);
				$fullVenue = $aflArr[count($aflArr) - 2];
				$fvArr = explode('-',$fullVenue);
				$venue = $fvArr[1];
				if (!isset($perGig[$venue])) {
					$perGig[$venue] = 0;
				}
				$perGig[$venue] += count($afileLines);
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
	echo "<h3>Socialoke Customer Phone Engagement (Number of Songs Per Phone)</h3>";
	foreach($pn as $ePhone) {
		$ph = base64_decode($ePhone);
		if (is_numeric($ph) && strlen($ph) == 11) {
			$final[$ph] = $pn2SongCount[$ph];
		}
	}
	arsort($final);
	foreach($final as $key => $val) {
		echo "Phone Number: ".$key.", songs: ".$val."<br/>";
	}
	echo $index." songs received.<br/>";
	echo count($final)." real phone numbers collected.<br/>";

	arsort($perGig);

	echo "<h3>Socialoke Customer Phone Engagement (Number of Songs Per Venue)</h3>";
	foreach($perGig as $key => $val) {
		echo $key.": ".$val."<br/>";
	}
?>
