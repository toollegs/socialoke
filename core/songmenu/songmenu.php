<?php

include_once('/var/www/html/beta/core/globals.php');

$url=startPage("songmenu");
$ph=session_get('ph');
$smsstring = $_GET['s'];
$smsstring = str_replace('+-+','+by+',$smsstring);
if (!isset($_GET['guid'])) {
	header("Location: /beta/core/sm/sm.php?s=".urlencode($smsstring)."&guid=".n_digit_random(6));
	exit();
}
$ph=session_get('ph');
$smsstring = $_GET['s'];
$smsstring = str_replace('+-+','+by+',$smsstring);
$smsstring = str_replace('&','&amp;',$smsstring);
$smsstring = str_replace("'",'&apos;',$smsstring);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body>
<div data-role="page" id="singit" data-theme="f">
	<div data-role="header" data-position="fixed" data-theme="f">
      		<h1> <?php echo strtoupper(str_replace('&apos;',"'",$smsstring)); ?> </h1>
	</div>
	<div data-role="content"  data-theme="f">	
		<ul id="mylistview" data-role="listview" data-theme="f">
			<li data-theme="f"><a href="../ui/ui.php?t=<?php echo urlencode($smsstring); ?>" data-role="button">SIGN UP TO SING IT!</a></li>
<!--
			<li data-theme="f" id="atf"><a href="#" id="<?php echo urlencode($smsstring); ?>" class="hover">Add To Favorites</a></li>
-->
			<li data-theme="f"><span>Lyrics<img src="../assets/coming-soon.jpg"/></span></li>
			<li data-theme="f"><span>YouTube<img src="../assets/coming-soon.jpg"/></span></li>
		</ul>
	</div>
<div id="back-button" class="centerer">
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
</div>
<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
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
</body>
</html>
