<?php
	$pn = array();
	$f = glob("/usr/logs/mysocialoke/archives/*");
	$index = 1;
	foreach($f as $hg) {
		$g = glob($hg."/*");
		if (count($g) > 0) {
			foreach($g as $afile) {
				$afileLines = file($afile);
				foreach($afileLines as $line) {
					$aflArr = explode("||",$line);
					for($i = 0; $i < 3; $i++) {
						$aflArr[$i] = str_replace('-','',$aflArr[$i]);
						$aflArr[$i] = str_replace(' ','',$aflArr[$i]);
						if (!is_numeric($aflArr[$i])) {
							if (base64_decode($aflArr[$i]) != '16179706735') {
								$pn[] = $aflArr[$i];
								$index += 1;
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
			echo "Phone Number: ".$ph."<br/>";
			$final[] = $ph;
		}
	}
	echo $index." songs received.<br/>";
	echo count($final)." real phone numbers collected.<br/>";
?>
