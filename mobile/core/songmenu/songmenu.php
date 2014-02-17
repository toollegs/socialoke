<?php

include '/var/www/html/beta/core/globals.php';

$url=startPage("songmenu");
$fromMO=session_get('ph');
$smsstring = $_GET['s'];
$smsstring = str_replace('+-+','+by+',$smsstring);
if (!isset($_GET['guid'])) {
	header("Location: /beta/core/sm/sm.php?s=".urlencode($smsstring)."&guid=".n_digit_random(6));
	exit();
}
$fromMO=session_get('ph');
$smsstring = $_GET['s'];
$smsstring = str_replace('+-+','+by+',$smsstring);
$smsstring = str_replace('&','%26',$smsstring);
?>

<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://www.GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /><link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" /><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script><script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script> 
</head>
<body>
<div data-role="page" id="singit" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      		<h1> <?php echo strtoupper($smsstring); ?> </h1>
	</div>
	<div data-role="content"  data-theme="f">	
		<ul id="mylistview" data-role="listview" data-theme="f">
			<li data-theme="f"><a href="../ui/ui.php?t=<?php echo $smsstring; ?>" class="hover">Sing it!</a></li>
			<li data-theme="f" id="atf"><a href="#" id="<?php echo urlencode($smsstring); ?>" class="hover">Add To Favorites</a></li>
			<li data-theme="f"><span>Lyrics<img src="../assets/coming-soon.jpg"/></span></li>
			<li data-theme="f"><span>YouTube<img src="../assets/coming-soon.jpg"/></span></li>
		</ul>
	</div>
<script type="text/javascript">
$(document).ready(function() {
	console.log("READY!");
	$('#mylistview li').click(function() {
		console.log("id: "+$(this).attr("id"));
		if ($(this).attr('id') == "atf") {
			console.log("<?php echo urlencode($smsstring); ?>");
			$.get('../addfav/addfav.php?s=<?php echo urlencode($smsstring); ?>&guid=<?php echo n_digit_random(6); ?>');
		} else {
			console.log("not doing it!");
		}
	});
});
</script>
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $fromMO; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
        <a href="http://www.gorhamproductions.com" rel="external"><img src="http://www.gorhamproductions.com/wp-content/uploads/2011/06/Gorham-Productions-logo.jpg" width="300" height="115"></a>
        <div data-role="footer" data-theme="f">
                <div style="text-align:center"> <a href="https://www.facebook.com/socialoke" rel="external"><img src="../assets/socialoke.jpg" width="36" height="36"></a><br />Like Us</div>
                </div>
        </div>
</div>
</body>
</html>
