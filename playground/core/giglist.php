<?php

include_once('/var/www/html/beta/core/globals.php');

$url=startPage('giglist');
$ph=session_get('ph');
function makeLinkArr()
{
	$host = $_GET['h'];

	$f = file('/usr/logs/mysocialoke/giglists/'.$host);
	// remove valid venues line
	unset($f[0]);
	$retArr = array();
	foreach($f as $gFile) {
// skip venue list line
		$ng = explode(',',$gFile);
		$hv = trim($ng[1]);
		if (!isset($hv) || $hv == "") {
			$retArr[] = makeVenueLine(strtoupper($ng[0]), "OFF!");
		} else {
			$retArr[] = makeVenueLine(strtoupper($ng[0]), $hv);			}
	}

return $retArr;
}

function makeVenueLine($d,$v)
{
	$knownVenues = getKnownVenues();
	$link = "";
	if(isset($knownVenues[$v.'-lnk'])) {
		$link = $knownVenues[$v.'-lnk'];
	}
	$fbImg = "<img src=\"/beta/core/assets/fb-for-giglist.png\" width=20 height=20/>";
	if (strpos(strtolower($v),'off') !== false) {
		$ret = "<a href=\"#\" data-role=\"button\">".$d.": OFF!</a>";
	} else {
		$ret = "<a href=\"".$link."\" data-role=\"button\" target=\"_blank\">".$d.": ".strtoupper($v).$fbImg."</a>";
# TODO: Wrap FB page in buttons so user can get back to WK
		#$ret = "<a href=\"gigwrapper.php?v=".urlencode($link)."\" data-role=\"button\" target=\"_blank\">".$d.": ".strtoupper($v).$fbImg."</a>";
	}

	return $ret;
}
?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="/beta/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body> 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div data-role="page" id="home" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
		<h1>GIG LIST FOR <?php echo strtoupper($_GET['h']); ?></h1>
	</div>
	<div data-role="content" data-theme="f">
	<?php 
		$linkArr = makeLinkArr();
		foreach($linkArr as $link) {
			echo $link;
		}
	?>
	</div>
	<div id="back-button" class="centerer">
                <h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        </div>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
</body>
</html>
