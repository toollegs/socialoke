<?php

include '/var/www/html/beta/core/globals.php';

$url = startPage("fav");
$ph=session_get('ph');
$favsLIs = '';

if (file_exists('/usr/logs/mysocialoke/venuesOn/'.$url['fullvenue'])) {
	$favs=file('/usr/logs/mysocialoke/favs/favs.'.$url['host'].'-'.$url['venue']);
	$theseFavs = array();
	if (count($favs) > 0) {
		$favsLIs='';
		$started = false;
		foreach($favs as $fav) {
			if (startsWith($fav,$ph)) {
				$theseFavs[] = $fav;
			}
		}
		$theseFavs = array_unique($theseFavs);
		sort($theseFavs);
				
		foreach($theseFavs as $fav) {
			if (startsWith($fav,$ph)) {
				if ($started == false) {
					$started=true;
					$favsLIs = '<center><h4>Click2Sing!</h4></center><ul id="mylistview" data-role="listview" data-autodividers="true" data-theme="f">';
				}
				$songArr=explode('||',$fav);
				$song=trim($songArr[1]);
				$songWithDash=str_replace(' by ',' - ',$song);
				$favsLIs .= "<li data-theme=\"f\"><a href=\"../userinput/userinput.php?t=".urlencode($song)."\" class=\"hover\">".$songWithDash."</a></li>";
			}
		}
		$favs = array_unique($favs);
		sort($favs);
		if ($started == true) {
			$favsLIs .= "</ul>";
		}
	}
	if ($favsLIs == '') {
		$favsLIs = "<h3>There are no Suggestions For You yet</h3>";
	}
}

?>

<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css"><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css"><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<script src="../ui-funcs.js"></script>
</head><body> 

<div data-role="page" id="page" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      	<h1>SUGGESTIONS</h1>
	</div>
	<div data-role="content" data-theme="f">	
		<?php echo $favsLIs; ?>
	</div>
	<div data-role="footer">
	</div>
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo urlencode($ph); ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
<a href="http://www.gorhamproductions.com" rel="external"><img src="http://www.gorhamproductions.com/wp-content/uploads/2011/06/Gorham-Productions-logo.jpg" width="300" height="115"></a>
	<div data-role="footer" data-theme="f">
		<div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="/beta/core/assets/socialoke.jpg" width="36" height="36"></a><br />Like Us</div>
		</div>
	</div>
</div>
</body></html>
