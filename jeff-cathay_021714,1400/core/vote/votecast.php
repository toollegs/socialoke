<html>
<head><title>Vote Cast!</title>
<body>
<?php
include '/var/www/html/beta/jeff-cathay_021714,1400/core/globals.php';
$uri = startPage('votecast');
$votes = $_POST;
$host = $uri['host'];
$ph = session_get('ph');
writeVotes($uri['fullvenue'],$ph,$votes);
echo "<center>YOUR VOTES HAVE BEEN CAST!</center>";
?>
<div style="text-align:center"><a href="../giglist.php?h=<?php echo $host; ?>&ph=<?php echo $ph; ?>" rel="external" data-role="button">See My Upcoming Gigs!</a></div>
<div id="back-button" class="centerer">
	<h3><a href="/beta/jeff-cathay_021714,1400/core/login.php?r=1&ph=<?php echo $ph; ?>&guid=<?php echo n_digit_random(6);?>" data-role="button">Back To Main Menu</a></h3>
	<?php echo file_get_contents('../assets/footer.php'); ?>
</div>
</body>
</html>
