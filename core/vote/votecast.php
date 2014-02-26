<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Gorham Productions</title><meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0,maximum-scale=1, user-scalable=no"><link rel="stylesheet" href="http://GorhamProductions.com/karaoke/themes/GorhamPro.min.css" /> <?php echo file_get_contents('http://s-oke.com/beta/core/assets/jquery-include.php'); ?>
</head>
<body>
<?php
include_once('/var/www/html/beta/core/globals.php');
$uri = startPage('votecast');
$votes = $_POST;
$host = $uri['host'];
$ph = session_get('ph');
writeVotes($uri['fullvenue'],$ph,$votes);
echo "<center>YOUR VOTES HAVE BEEN CAST!</center>";
?>
<div style="text-align:center"><a href="../giglist.php?h=<?php echo $host; ?>&ph=<?php echo $ph; ?>" rel="external" data-role="button">See My Upcoming Gigs!</a></div>
<div id="back-button" class="centerer">
	<h3><a href="/beta/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
	<?php include_once('/var/www/html/beta/core/assets/footer.php'); ?>
</div>
</body>
</html>
